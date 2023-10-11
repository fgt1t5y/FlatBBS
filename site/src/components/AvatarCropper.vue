<template>
  <Space direction="vertical" :style="{ width: `${size}px` }" fill>
    <div
      class="cropper-container"
      :style="{ height: `${size}px` }"
      @mousedown="mousedown"
      @mousemove="mousemove"
      @mouseup="mouseup"
    >
      <img ref="imageSrc" :src="imageURL" alt="src" style="display: none" />
      <canvas ref="canvasRef" :width="size" :height="size"></canvas>
      <div class="cropper-wrapper">
        <div class="cropper-mask"></div>
      </div>
    </div>
    <TypographyText>显示比例（最小 - 最大）</TypographyText>
    <Slider
      v-model="scale"
      :min="minScale"
      :max="1.0"
      :step="0.01"
      :format-tooltip="displayScale"
      :disabled="!imageURL || imageException"
      @change="onScaleChange"
    />
  </Space>
</template>

<script setup lang="ts">
import { Slider, TypographyText, Space } from '@arco-design/web-vue'
import { ref, onMounted, computed, watch } from 'vue'
import './AvatarCropper.css'

defineOptions({
  name: 'AvatarCropper',
})

interface AvatarCropperProps {
  size?: number
  image?: File
}

const props = withDefaults(defineProps<AvatarCropperProps>(), {
  size: 320,
  image: undefined,
})
const emits = defineEmits<{
  (e: 'load'): void
  (e: 'error', message: string): void
}>()
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
const imageException = ref<boolean>(false)
let ctx: CanvasRenderingContext2D | null = null
const initCanvas = () => {
  if (imageSrc.value!.height > imageSrc.value!.width) {
    minScale = Math.min(props.size / imageSrc.value!.width, 1)
  } else {
    minScale = Math.min(props.size / imageSrc.value!.height, 1)
  }
  scale.value = minScale

  drawAt(0, 0)
}
const borderDistanceX = computed(() => {
  return imageSrc.value!.width * scale.value - props.size
})
const borderDistanceY = computed(() => {
  return imageSrc.value!.height * scale.value - props.size
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
  ctx?.clearRect(0, 0, props.size, props.size)
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

onMounted(() => {
  ctx = canvasRef.value!.getContext('2d')
  window.addEventListener('mouseup', () => {
    if (renderStatus.isDraging) {
      renderStatus.isDraging = false
      checkOverBorder()
    }
  })
  imageSrc.value!.addEventListener('load', () => {
    if (
      imageSrc.value!.width < props.size ||
      imageSrc.value!.height < props.size
    ) {
      emits('error', `图像高宽至少为 ${props.size} px`)
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
      console.log(file)
      imageURL.value = window.URL.createObjectURL(props.image!)
    }
  },
)

defineExpose({ destoryCropper })
</script>
