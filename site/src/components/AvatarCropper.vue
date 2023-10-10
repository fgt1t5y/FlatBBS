<template>
  <section class="cropper" :style="{ width: `${size}px` }">
    <div
      class="cropper-container"
      :style="{ height: `${size}px` }"
      @mousedown="mousedown"
      @mousemove="mousemove"
      @mouseup="mouseup"
    >
      <img
        ref="imageSrc"
        src="https://p1-arco.byteimg.com/tos-cn-i-uwbnlip3yd/6480dbc69be1b5de95010289787d64f1.png~tplv-uwbnlip3yd-webp.webp"
        alt="src"
        style="display: none"
      />
      <canvas ref="canvasRef" :width="size" :height="size"></canvas>
      <div class="cropper-wrapper">
        <div class="cropper-mask"></div>
      </div>
    </div>
    <Slider :min="1.0" :max="2.0" :step="0.01" />
  </section>
</template>

<script setup lang="ts">
import { Slider } from '@arco-design/web-vue'
import { ref, onMounted } from 'vue'
import '@/style/AvatarCropper.css'

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
const scale = ref<number>(1.0)
const imageSizeException = ref<boolean>(false)
let ctx: CanvasRenderingContext2D | null = null
const initCanvas = () => {
  ctx?.drawImage(imageSrc.value!, 0, 0, 400, 400, 0, 0, 400, 400)
}
const mousedown = (ev: MouseEvent) => {
  if (imageSizeException.value) return

  const { clientX, clientY } = ev
  renderStatus.isDraging = true
  renderStatus.startX = clientX
  renderStatus.startY = clientY
  console.error(renderStatus)
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
}
const draw = () => {
  ctx?.clearRect(0, 0, props.size, props.size)
  const currentX = renderStatus.clientX + renderStatus.deltaX
  const currentY = renderStatus.clientY + renderStatus.deltaY

  ctx?.drawImage(
    imageSrc.value!,
    currentX,
    currentY,
    imageSrc.value!.width,
    imageSrc.value!.height,
  )

  console.log(renderStatus)
}

onMounted(() => {
  ctx = canvasRef.value!.getContext('2d')
  if (
    imageSrc.value!.width < props.size ||
    imageSrc.value!.height < props.size
  ) {
    imageSizeException.value = true
    ctx!.font = 'bold 24px serif'
    ctx!.fillStyle = 'red'
    ctx!.fillText(`图像高宽至少为 ${props.size}`, 0, 128)
    return
  }
  initCanvas()
})
</script>
