<template>
  <div class="container">
    <div class="row">
      <div class="col-8">
        <div class="card-section">
          <div class="card-section-title">
            <h3>Productos</h3>
          </div>
          <div class="card-section-container">
            <div class="filters">
              <select>
                <option value="">Todas las categorías</option>
                <option v-for="c in categorias" :key="c" :value="c">
                  {{ c }}
                </option>
              </select>
              <input v-model="search" class="input-search" placeholder="Buscar" />
            </div>
            <div class="section-cards">
              <card v-for="card in cards" :key="card.id" :titulo="card.titulo"></card>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card-section">
          <div class="card-section-title">
            <h3>Pedido</h3>
          </div>
          <div class="card-section-container">
            <div class="flex gap-2 justify-between">
              <select>
                <option value="">Elegir cliente</option>
                <option v-for="c in clientes" :key="c" :value="c">
                  {{ c }}
                </option>
              </select>
              <button>+ Cliente</button>
            </div>

            <div class="py-2">
              <h5 class="py-2 px-1 font-bold">Elegir Mesa:</h5>
              <select class="w-full">
                <option value="">Elegir cliente</option>
                <option v-for="c in cards" :key="c.id" :value="c">
                  {{ c.mesa }}
                </option>
              </select>
            </div>

            <div class="py-2">
              <h5 class="py-2 px-1 font-bold">Tipo de orden:</h5>
              <div class="flex justify-between">
                <label>
                  <input type="radio" v-model="orderType" value="takeAway" />
                  Take Away
                </label>
                <br />
                <label>
                  <input type="radio" v-model="orderType" value="dineIn" />
                  Dine-in
                </label>
                <br />
                <label>
                  <input type="radio" v-model="orderType" value="homeDelivery" />
                  Home Delivery
                </label>
              </div>
            </div>

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
                </tbody>
              </table>

              <div class="order-resume">
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

                <ul class="total">
                  <li>
                    <span><strong>Total:</strong></span>
                    <span><strong>20.00 €</strong></span>
                  </li>
                </ul>

                <h5 class="py-2 px-1 font-bold mt-2 mb-2">Método de pago:</h5>
                <div class="flex" style="padding-left: 1rem">
                  <label>
                    <input type="radio" v-model="paidType" value="takeAway" />
                    Cash
                  </label>
                  <label style="margin-left: 1rem">
                    <input type="radio" v-model="paidType" value="dineIn" />
                    Card
                  </label>
                </div>

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
.section-cards {
  display: flex;
  flex-wrap: wrap;
}
.filters {
  padding: 8px;
  display: flex;
  justify-content: space-between;
}

.order-resume {
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
