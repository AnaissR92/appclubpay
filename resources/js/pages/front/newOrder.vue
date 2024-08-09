<template>
  <div>
    <div v-if="!pedidoShow" id="que-pedir" class="text-center py-6" style="">
      <h3 class="text-2xl font-bold" style="color: #ff5900">¿Cómo deseas pedir?</h3>
      <div
        class="grid grid-cols-2 pt-6 text-center justify-center gap-12 max-w-2xl m-auto"
      >
        <div
          @click="pedidoShow = true"
          class="text-center shadow-lg rounded-lg py-6 hover:-translate-y-2 transition-all cursor-pointer hover:shadow-xl"
        >
          <img
            src="https://appclubpay.com/public/front-images/temp/table_2204277.png"
            width="64px"
            class="m-auto py-2"
          />
          <h4>Pedir a la mesa</h4>
        </div>
        <div
          @click="pedidoShow = true"
          class="text-center shadow-lg rounded-lg py-6 hover:-translate-y-2 transition-all cursor-pointer hover:shadow-xl"
        >
          <img
            src="https://appclubpay.com/public/front-images/temp/scooters_2304852.png"
            width="64px"
            class="m-auto py-2"
          />
          <h4>Pedido para llevar</h4>
        </div>
      </div>
    </div>

    <div id="new-order" v-if="pedidoShow" class="grid grid-cols-3">
      <div class="col-span-2 pr-6">
        <div class="card-section">
          <div class="card-section-title">
            <h3 class="text-2xl">Productos</h3>
          </div>
          <div class="card-section-container">
            <div class="categories">
              <category v-for="c in categorias" :key="c.id" :titulo="c"></category>
            </div>

            <!-- Productos -->
            <div class="products">
              <card v-for="card in cards" :key="card.id" :titulo="card.titulo"></card>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4 pl-6">
        <div class="order-wrap">
          <h3 class="text-2xl mb-6">Pedido</h3>

          <div class="card-section-container">
            <div class="py-2">
              <table class="w-full mb-4">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Precio</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="py-1 px-1">
                      <img
                        src="https://appclubpay.com/public/front-images/temp/tortilla.jpg"
                        class=""
                        width="32px"
                      />
                    </td>
                    <td>
                      <input
                        type="number"
                        min="1"
                        max="100"
                        value="1"
                        class="qty-input"
                      />
                    </td>
                    <td>
                      <span><strong>20.00 €</strong></span>
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td class="py-1 px-1">
                      <img
                        src="https://appclubpay.com/public/front-images/temp/tortilla.jpg"
                        class=""
                        width="32px"
                      />
                    </td>
                    <td>
                      <input
                        type="number"
                        min="1"
                        max="100"
                        value="1"
                        class="qty-input"
                      />
                    </td>
                    <td>
                      <span><strong>20.00 €</strong></span>
                    </td>
                    <td></td>
                  </tr>
                </tbody>
              </table>

              <div class="order-resume">
                <!--
              <ul>
                <li>
                  <span>Subtotal:</span>
                  <span>0.00 €</span>
                </li>
                <li>
                  <span>Descuento:</span>
                  <span>0.00 €</span>
                </li>
                <li>
                  <span>VAT/TAX:</span>
                  <span>0.00 €</span>
                </li>
                <li>
                  <span>Delivery charge:</span>
                  <span>0.00 €</span>
                </li>
              </ul>
              -->

                <ul class="total">
                  <li>
                    <span><strong>Total:</strong></span>
                    <span><strong>20.00 €</strong></span>
                  </li>
                </ul>

                <h5 class="py-2 px-1 font-bold mt-2 mb-2">Método de pago:</h5>
                <select class="w-full">
                  <option>Efectivo</option>
                  <option>Tarjeta</option>
                  <option>Pagar después de comer</option>
                </select>

                <div class="flex mt-4" style="gap: 10px !important">
                  <button class="canel">Cancelar</button>
                  <button class="success">Realizar pedido</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showList: false,
      pedidoShow: false,
      orderType: "takeAway",
      paidType: "cash",
      cards: [],
      categorias: ["Bebidas", "Pizzas", "Adicionales"],
      clientes: ["John Doe", "Micky Vainilla", "Jorge Capusoto"],
    };
  },
  created() {
    // Generar los objetos Card con id y titulo
    for (let i = 1; i <= 10; i++) {
      this.cards.push({
        id: i,
        titulo: `Mesa ${i}`,
        categorias: ["Pastas", "Pizzas", "Bebidas", "Otros"],
        pedido: [
          {
            cant: i + 1,
            titulo: `Plato de comida ${i}`,
            precio: "$" + i * 20,
          },
        ],
      });
    }
  },
};
</script>

<style scoped>
.products {
  display: flex;
  flex-wrap: wrap;
  @apply grid grid-cols-3 gap-6;
}
.categories {
  padding: 8px;
  display: flex;
  justify-content: space-around;
  gap: 32px;
}

table td {
  text-align: center;
}
table td img {
  margin: 0 auto;
}

.order-wrap {
  position: sticky;
  top: 100px;
  @apply bg-white px-2 py-4 shadow-lg rounded-lg;
}

/* Buton */
button {
  background-color: #ddd;
  padding: 0.5rem 0.5rem;
  border-radius: 0.5rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}
button i {
  font-size: 0.8rem;
  margin-right: 0.5rem;
}
button:hover {
  background-color: black;
  color: white;
}
button.success {
  background-color: #02ad29;
  color: white;
}

.order-resume ul li {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 3px 6px;
}
.order-resume ul.total {
  border-top: 1px solid #ddd;
  margin-top: 0.5rem;
  padding-top: 0.5rem;
}

button {
  width: 100%;
}
img {
  border-radius: 6px;
}
.qty-input {
  border: 0;
  max-width: 64px;
}
</style>
