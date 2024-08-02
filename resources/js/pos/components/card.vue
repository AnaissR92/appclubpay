<template>
  <div class="card py-2">
    <img
      src="https://appclubpay.com/public/front-images/temp/tortilla.jpg"
      class="w-full"
    />
    <p class="text-center mt-2 mb-1">{{ titulo }}</p>
    <h6 class="text-center mt-2 mb-1 font-bold">20.00 €</h6>
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
