<template>
  <div class="card">
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

<style scoped>
/* CARD */
.card {
  background-color: white;
  cursor: pointer;
  transition: all 0.3s ease;
  border-radius: 10px;
  padding-bottom: 10px;
}
.card img {
  margin: auto;
  transition: all 0.3s ease;
  -webkit-border-top-left-radius: 10px;
  -webkit-border-top-right-radius: 10px;
  -moz-border-radius-topleft: 10px;
  -moz-border-radius-topright: 10px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.card:hover {
  transform: translateY(-4px);
}
</style>
