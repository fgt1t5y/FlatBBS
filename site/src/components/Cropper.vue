<template>
  <NSpace vertical :style="{ width: `${width}px` }" fill>
    <div
      class="cropper-container"
      :style="{ height: `${height}px` }"
      @mousedown="mousedown"
      @mousemove="mousemove"
      @mouseup="mouseup"
    >
      <img ref="imageSrc" :src="imageURL" alt="src" style="display: none" />
      <canvas ref="canvasRef" :width="width" :height="height"></canvas>
      <div v-show="cropMask" class="cropper-wrapper">
        <div class="cropper-mask"></div>
      </div>
    </div>
    <NText>显示比例（最小 - 最大）</NText>
    <NSlider
      v-model:value="scale"
      :min="minScale"
      :max="1.0"
      :step="0.01"
      :format-tooltip="displayScale"
      :disabled="!imageURL || imageException || ratioException"
      @update:value="onScaleChange"
    />
  </NSpace>
</template>

<script setup lang="ts">
import { NText, NSlider, NSpace } from 'naive-ui'
import { ref, onMounted, computed, watch } from 'vue'
import '@/style/Cropper.css'

defineOptions({
  name: 'Cropper',
})

interface CropperProps {
  height: number
  width: number
  image?: File
  cropMask?: boolean
}

const props = withDefaults(defineProps<CropperProps>(), {
  height: 320,
  width: 320,
  image: undefined,
  cropMask: true,
})
const emits = defineEmits<{
  (e: 'load'): void
  (e: 'error', message: string): void
}>()
const supportedType = ['image/jpeg', 'image/png', 'image/webp']
const imageURL = ref<string>('')
const imageSrc = ref<HTMLImageElement>()
const canvasRef = ref<HTMLCanvasElement>()
const renderStatus = {
  isDraging: false,
  startX: 0,
  startY: 0,
  clientX: 0,
  clientY: 0,
  deltaX: 0,
  deltaY: 0,
}
let minScale = 0
const scale = ref<number>(0.5)
const displayScale = (n: number) => {
  return n.toFixed(2)
}
const hasFile = ref<boolean>(false)
const imageException = ref<boolean>(false)
const ratioException = ref<boolean>(false)
let ctx: CanvasRenderingContext2D | null = null
const initCanvas = () => {
  if (props.width > props.height) {
    if (imageSrc.value!.height > imageSrc.value!.width) {
      minScale = Math.min(props.width / imageSrc.value!.width, 1)
    } else {
      minScale = Math.min(props.width / imageSrc.value!.height, 1)
    }
  } else {
    if (imageSrc.value!.height > imageSrc.value!.width) {
      minScale = Math.min(props.height / imageSrc.value!.width, 1)
    } else {
      minScale = Math.min(props.height / imageSrc.value!.height, 1)
    }
  }
  if (displayScale(minScale) === '1.00') {
    ratioException.value = true
  }
  scale.value = minScale

  drawAt(0, 0)
}
const borderDistanceX = computed(() => {
  return imageSrc.value!.width * scale.value - props.width
})
const borderDistanceY = computed(() => {
  return imageSrc.value!.height * scale.value - props.height
})
const drawAt = (x: number, y: number) => {
  ctx?.drawImage(
    imageSrc.value!,
    x,
    y,
    imageSrc.value!.width * scale.value,
    imageSrc.value!.height * scale.value,
  )
}
const draw = () => {
  ctx?.clearRect(0, 0, props.width, props.height)
  const currentX = renderStatus.clientX + renderStatus.deltaX
  const currentY = renderStatus.clientY + renderStatus.deltaY

  drawAt(currentX, currentY)
}
const onScaleChange = () => {
  // check over-border and redraw
  checkOverBorder()
}
const checkOverBorder = () => {
  if (renderStatus.clientX > 0) {
    renderStatus.clientX = 0
  }
  if (renderStatus.clientX < -borderDistanceX.value) {
    renderStatus.clientX = -borderDistanceX.value
  }
  if (renderStatus.clientY > 0) {
    renderStatus.clientY = 0
  }
  if (renderStatus.clientY < -borderDistanceY.value) {
    renderStatus.clientY = -borderDistanceY.value
  }
  drawAt(renderStatus.clientX, renderStatus.clientY)
}
const mousedown = (ev: MouseEvent) => {
  if (imageException.value) return

  const { clientX, clientY } = ev
  renderStatus.isDraging = true
  renderStatus.startX = clientX
  renderStatus.startY = clientY
}
const mousemove = (ev: MouseEvent) => {
  if (!renderStatus.isDraging) return

  const { clientX, clientY } = ev
  renderStatus.deltaX = clientX - renderStatus.startX
  renderStatus.deltaY = clientY - renderStatus.startY
  draw()
}
const mouseup = (ev: MouseEvent) => {
  renderStatus.isDraging = false
  const { clientX, clientY } = ev
  const deltaX = clientX - renderStatus.startX
  const deltaY = clientY - renderStatus.startY
  renderStatus.clientX += deltaX
  renderStatus.clientY += deltaY
  renderStatus.deltaX = 0
  renderStatus.deltaY = 0
  checkOverBorder()
}
const destoryCropper = () => {
  URL.revokeObjectURL(imageURL.value)
}
const getBlobAsync = (): Promise<Blob | null> => {
  return new Promise(function (resolve, reject) {
    canvasRef.value!.toBlob(
      function (blob) {
        if (!blob) {
          emits('error', '失败，请重试。')
          reject(blob)
        }
        resolve(blob)
      },
      'image/jpeg',
      0.8,
    )
  })
}

onMounted(() => {
  console.log('mo')
  ctx = canvasRef.value!.getContext('2d')
  window.addEventListener('mouseup', () => {
    if (renderStatus.isDraging) {
      renderStatus.isDraging = false
      checkOverBorder()
    }
  })
  imageSrc.value!.addEventListener('error', () => {
    hasFile.value && emits('error', '无法加载此文件')
  })
  imageSrc.value!.addEventListener('load', () => {
    if (
      imageSrc.value!.width < props.width ||
      imageSrc.value!.height < props.height
    ) {
      emits('error', `图像高宽至少为 ${props.height}x${props.width} px`)
      return
    } else {
      imageException.value = false
      initCanvas()
      emits('load')
    }
  })
})

watch(
  () => props.image,
  (file) => {
    if (file) {
      if (supportedType.indexOf(file.type) === -1) {
        emits('error', '不支持的格式')
        return
      }
      hasFile.value = true
      imageURL.value = window.URL.createObjectURL(props.image!)
    }
  },
)

defineExpose({
  destoryCropper,
  getBlobAsync,
})
</script>
