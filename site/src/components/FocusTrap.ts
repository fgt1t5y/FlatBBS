import {
  h,
  defineComponent,
  ref,
  Fragment,
  onMounted,
  onBeforeUnmount,
  watch,
  useId,
} from 'vue';
import {
  resolveTo,
  focusFirstDescendant,
  focusLastDescendant,
  delay,
} from '@/utils';

import type { PropType } from 'vue';

let stack: string[] = [];

const getPreciseEventTarget = (event: Event) => {
  return event.composedPath()[0] || null;
};

export const FocusTrap = defineComponent({
  name: 'FocusTrap',
  props: {
    disabled: Boolean,
    active: Boolean,
    autoFocus: {
      type: Boolean,
      default: true,
    },
    onEsc: {
      type: Function as PropType<(e: KeyboardEvent) => void>,
      default: undefined,
    },
    initialFocusTo: {
      type: String,
      default: undefined,
    },
    finalFocusTo: {
      type: String,
      default: undefined,
    },
    returnFocusOnDeactivated: {
      type: Boolean,
      default: true,
    },
  },
  setup(props) {
    const id = useId();
    const focusableStartRef = ref<HTMLElement | null>(null);
    const focusableEndRef = ref<HTMLElement | null>(null);
    let activated = false;
    let ignoreInternalFocusChange = false;
    const lastFocusedElement: Element | null =
      typeof document === 'undefined' ? null : document.activeElement;

    function isCurrentActive(): boolean {
      const currentActiveId = stack[stack.length - 1];
      return currentActiveId === id;
    }

    function handleDocumentKeydown(e: KeyboardEvent): void {
      if (e.code === 'Escape') {
        if (isCurrentActive()) {
          props.onEsc?.(e);
        }
      }
    }

    onMounted(() => {
      watch(
        () => props.active,
        (value) => {
          if (value) {
            activate();
            document.addEventListener('keydown', handleDocumentKeydown);
          } else {
            document.removeEventListener('keydown', handleDocumentKeydown);
            if (activated) {
              deactivate();
            }
          }
        },
        {
          immediate: true,
        },
      );
    });

    onBeforeUnmount(() => {
      document.removeEventListener('keydown', handleDocumentKeydown);
      if (activated) {
        deactivate();
      }
    });

    function handleDocumentFocus(e: FocusEvent): void {
      if (ignoreInternalFocusChange) {
        return;
      }
      if (isCurrentActive()) {
        const mainEl = getMainEl();
        if (mainEl === null) {
          return;
        }
        if (mainEl.contains(getPreciseEventTarget(e) as Node | null)) {
          return;
        }
        // I don't handle shift + tab status since it's too tricky to handle
        // Not impossible but I need to sleep
        resetFocusTo('first');
      }
    }

    function getMainEl(): ChildNode | null {
      const focusableStartEl = focusableStartRef.value;
      if (focusableStartEl === null) {
        return null;
      }
      let mainEl: ChildNode | null = focusableStartEl;
      // eslint-disable-next-line no-constant-condition
      while (true) {
        mainEl = mainEl.nextSibling;
        if (mainEl === null) {
          break;
        }
        if (mainEl instanceof Element && mainEl.tagName === 'DIV') {
          break;
        }
      }
      return mainEl;
    }

    function activate(): void {
      if (props.disabled) {
        return;
      }
      stack.push(id);
      if (props.autoFocus) {
        const { initialFocusTo } = props;
        if (initialFocusTo === undefined) {
          delay(() => resetFocusTo('first'));
        } else {
          delay(() =>
            resolveTo(initialFocusTo)?.focus({ preventScroll: true }),
          );
        }
      }
      activated = true;
      document.addEventListener('focus', handleDocumentFocus, true);
    }

    function deactivate(): void {
      if (props.disabled) {
        return;
      }
      document.removeEventListener('focus', handleDocumentFocus, true);
      stack = stack.filter((idInStack) => idInStack !== id);
      if (isCurrentActive()) {
        return;
      }
      const { finalFocusTo } = props;
      if (finalFocusTo !== undefined) {
        resolveTo(finalFocusTo)?.focus({ preventScroll: true });
      } else if (props.returnFocusOnDeactivated) {
        if (lastFocusedElement instanceof HTMLElement) {
          ignoreInternalFocusChange = true;
          lastFocusedElement.focus({ preventScroll: true });
          ignoreInternalFocusChange = false;
        }
      }
    }

    function resetFocusTo(target: 'last' | 'first'): void {
      if (!isCurrentActive()) {
        return;
      }
      if (props.active) {
        const focusableStartEl = focusableStartRef.value;
        const focusableEndEl = focusableEndRef.value;
        if (focusableStartEl !== null && focusableEndEl !== null) {
          const mainEl = getMainEl();
          if (mainEl == null || mainEl === focusableEndEl) {
            ignoreInternalFocusChange = true;
            focusableStartEl.focus({ preventScroll: true });
            ignoreInternalFocusChange = false;
            return;
          }
          ignoreInternalFocusChange = true;

          const focused =
            target === 'first'
              ? focusFirstDescendant(mainEl)
              : focusLastDescendant(mainEl);
          ignoreInternalFocusChange = false;
          if (!focused) {
            ignoreInternalFocusChange = true;
            focusableStartEl.focus({ preventScroll: true });
            ignoreInternalFocusChange = false;
          }
        }
      }
    }

    function handleStartFocus(e: FocusEvent): void {
      if (ignoreInternalFocusChange) {
        return;
      }
      const mainEl = getMainEl();
      if (mainEl === null) {
        return;
      }
      if (e.relatedTarget !== null && mainEl.contains(e.relatedTarget as any)) {
        // if it comes from inner, focus last
        resetFocusTo('last');
      } else {
        // otherwise focus first
        resetFocusTo('first');
      }
    }

    function handleEndFocus(e: FocusEvent): void {
      if (ignoreInternalFocusChange) {
        return;
      }
      if (
        e.relatedTarget !== null &&
        e.relatedTarget === focusableStartRef.value
      ) {
        // if it comes from first, focus last
        resetFocusTo('last');
      } else {
        // otherwise focus first
        resetFocusTo('first');
      }
    }

    return {
      focusableStartRef,
      focusableEndRef,
      focusableStyle: 'position: absolute; height: 0; width: 0;',
      handleStartFocus,
      handleEndFocus,
    };
  },
  render() {
    const { default: defaultSlot } = this.$slots;
    if (defaultSlot === undefined) {
      return null;
    }
    if (this.disabled) {
      return defaultSlot();
    }
    const { active, focusableStyle } = this;
    return h(Fragment, null, [
      h('div', {
        'aria-hidden': 'true',
        tabindex: active ? '0' : '-1',
        ref: 'focusableStartRef',
        style: focusableStyle,
        onFocus: this.handleStartFocus,
      }),
      defaultSlot(),
      h('div', {
        'aria-hidden': 'true',
        style: focusableStyle,
        ref: 'focusableEndRef',
        tabindex: active ? '0' : '-1',
        onFocus: this.handleEndFocus,
      }),
    ]);
  },
});
