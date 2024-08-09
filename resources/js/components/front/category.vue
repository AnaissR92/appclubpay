<template>
  <div class="category py-2">
    <img
      src="https://appclubpay.com/public/front-images/temp/bottle_10612366.png"
      class="w-full"
    />
    <h6 class="text-center mt-2 mb-1">{{ titulo }}</h6>
  </div>
</template>

<script>
export default {
  props: {
    titulo: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
img {
  max-width: 64px;
  margin: 0 auto;
}
h6 {
  font-weight: bold;
}
</style>
