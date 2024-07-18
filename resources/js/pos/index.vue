<template>
  <div class="row">
    <div class="left-panel">
      <div class="">
        <h1 class="text-2xl">Pedidos</h1>
        <div class="row mt-4">
          <card v-for="card in cards" :key="card.id" :titulo="card.titulo"></card>
        </div>
      </div>
    </div>
    <div class="right-panel">
      <div class="panel-top">
        <button>
          <i class="fas fa-plus"></i>
          <span>Nuevo pedido</span>
        </button>
      </div>
      <div class="panel-list">
        <ul>
          <li>
            <div class="order-line-description">
              <i class="fas fa-chevron-right"></i>
              <span>1</span>
              <h6>Puré de papas</h6>
            </div>
            <div>
              <span>$25.00</span>
              <i class="fas fa-trash"></i>
            </div>
          </li>
          <li>
            <div class="order-line-description">
              <i class="fas fa-chevron-right"></i>
              <span>1</span>
              <h6>Puré de papas</h6>
            </div>
            <div>
              <span>$25.00</span>
              <i class="fas fa-trash"></i>
            </div>
          </li>
          <li>
            <div class="order-line-description">
              <i class="fas fa-chevron-right"></i>
              <span>1</span>
              <h6>Puré de papas</h6>
            </div>
            <div>
              <span>$25.00</span>
              <i class="fas fa-trash"></i>
            </div>
          </li>
          <li>
            <div class="order-line-description">
              <i class="fas fa-chevron-right"></i>
              <span>1</span>
              <h6>Puré de papas</h6>
            </div>
            <div>
              <span>$25.00</span>
              <i class="fas fa-trash"></i>
            </div>
          </li>
        </ul>
      </div>
      <div class="panel-bottom">
        <div class="row">
          <div class="col-6 text-sm">Subtotal</div>
          <div class="col-6 price"><strong>$200</strong></div>
        </div>
        <div class="row">
          <div class="col-6">Tax</div>
          <div class="col-6 price"><strong>$45</strong></div>
        </div>
        <div class="row py-2">
          <div class="col-6 text-base"><strong>Pago total</strong></div>
          <div class="col-6 text-base price"><strong>$245</strong></div>
        </div>
        <div class="row py-2">
          <div class="col-6">
            <button class="w-full">
              <i class="fas fa-pen"></i>
              <span>Editar pedido</span>
            </button>
          </div>
          <div class="col-6">
            <button class="success w-full">
              <i class="fas fa-check"></i>
              <span>Pago</span>
            </button>
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
      cards: [],
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
