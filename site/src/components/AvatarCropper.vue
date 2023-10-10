<template>
  <section class="cropper" :style="{ width: `${size}px` }">
    <div
      class="cropper-container"
      :style="{ height: `${size}px` }"
      @mousedown="mousedown"
      @mousemove="mousemove"
      @mouseup="mouseup"
    >
      <img ref="imageSrc" src="" alt="src" style="display: none" />
      <canvas ref="canvasRef" :width="size" :height="size"></canvas>
      <div class="cropper-wrapper">
        <div class="cropper-mask"></div>
      </div>
    </div>
    <Slider
      v-model="scale"
      :min="minScale"
      :max="1.0"
      :step="0.01"
      :format-tooltip="displayScale"
      @change="onScaleChange"
    />
  </section>
</template>

<script setup lang="ts">
import { Slider } from '@arco-design/web-vue'
import { ref, onMounted } from 'vue'
import './AvatarCropper.css'
import { computed } from 'vue'

defineOptions({
  name: 'AvatarCropper',
})

interface AvatarCropperProps {
  size?: number
}

const props = withDefaults(defineProps<AvatarCropperProps>(), {
  size: 256,
})
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
const imageSizeException = ref<boolean>(false)
let ctx: CanvasRenderingContext2D | null = null
let imgHeight = 0
let imgWidth = 0
const renderErrorMessage = (message: string) => {
  imageSizeException.value = true
  ctx!.font = 'bold 16px serif'
  ctx!.fillStyle = 'red'
  ctx!.fillText(message, 64, 128)
}
const initCanvas = () => {
  imageSrc.value!.src =
    'https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/6480dbc69be1b5de95010289787d64f1.png~tplv-uwbnlip3yd-webp.webp'
  imageSrc.value!.onerror = () => {
    renderErrorMessage('渲染错误：没有图像源。')
    return
  }
  imageSrc.value!.onload = () => {
    imgHeight = imageSrc.value!.height
    imgWidth = imageSrc.value!.width
    if (imgWidth < props.size || imgHeight < props.size) {
      renderErrorMessage(`图像高宽至少为 ${props.size}`)
      return
    }
  }

  minScale = Math.min(props.size / imageSrc.value!.height, 1)
  scale.value = minScale

  drawAt(0, 0)
}
const borderDistanceX = computed(() => {
  return imgWidth * scale.value - props.size
})
const borderDistanceY = computed(() => {
  return imgHeight * scale.value - props.size
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
  if (imageSizeException.value) return

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
  console.error(renderStatus)
  checkOverBorder()
}

onMounted(() => {
  ctx = canvasRef.value!.getContext('2d')
  initCanvas()
})
</script>
