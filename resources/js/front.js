import { createApp } from 'vue/dist/vue.esm-bundler.js';

import NewOrder from './pages/front/newOrder.vue';
import Category from './components/front/category.vue';
import Card from './components/pos/card.vue';

const app = createApp({});

app.component('new-order', NewOrder);
app.component('category', Category);
app.component('card', Card);
app.mount("#front");
