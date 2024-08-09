<template>
  <div class="row">
    <div class="">
      <div class="flex justify-between">
        <h1 class="text-2xl text-primary">POS Pedidos</h1>
        <a href="/pos/new">
          <button>
            <ion-icon name="add-circle-outline" class="mr-2"></ion-icon>
            Nuevo pedido
          </button>
        </a>
      </div>

      <div class="card-wrap my-4">
        <input v-model="search" class="search" placeholder="Buscar" />
        <select>
          <option>Todos</option>
          <option>Opcion 1</option>
          <option>Opcion 2</option>
        </select>
        <div>
          <VueDatePicker
            v-model="date"
            range
            :enable-time-picker="false"
            placeholder="Desde - Hasta"
          ></VueDatePicker>
        </div>
        <button>Filtrar datos</button>
      </div>
      <div class="card-wrap mt-2 px-0 py-0">
        <table class="table rounded-lg">
          <thead>
            <tr>
              <td>ID</td>
              <td>Fecha</td>
              <td>Cliente</td>
              <td>Mesa</td>
              <td>Total</td>
              <td>Status</td>
              <td></td>
            </tr>
          </thead>

          <tbody>
            <tr v-for="o in orders" :key="o">
              <td>{{ o.order_id }}</td>
              <td>{{ o.fecha }}<br />{{ o.hora }}</td>
              <td>{{ o.customer.name }}</td>
              <td>{{ o.mesa }}</td>
              <td>{{ o.total }} €</td>
              <td>
                <span class="tag">{{ o.status }}</span>
              </td>
              <td>
                <ion-icon name="create-outline"></ion-icon>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      search: "",
      date: "",
      orders: [],
    };
  },
  created() {
    // Generar los objetos Card con id y titulo
    for (let i = 1; i <= 10; i++) {
      var mesa = i > 5 ? "Mesa 1" : "Mesa 2";

      this.orders.push({
        id: i,
        order_id: 1000 + i,
        fecha: "20 Jul 24",
        hora: "10:00 AM",
        customer: {
          name: "Michael Jackson",
        },
        mesa: mesa,
        total: "219.50",
        status: "Delivered",
      });
    }
  },
};
</script>

<style scoped>
.card-wrap {
  display: flex;
  flex-direction: row;
  width: 100%;
  align-items: center;
  justify-content: space-between;
  background-color: white;
  @apply shadow-sm px-3 py-2 rounded-lg;
}
.card-wrap input,
.card-wrap select {
  min-width: 25%;
  border-color: #ddd;
  padding: 6px 12px;
  border-radius: 0.5rem !important;
  font-size: 0.8rem !important;
}
.card-wrap button {
  min-width: 22%;
  @apply bg-primary text-white rounded-lg;
}
</style>
