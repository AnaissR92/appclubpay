//require('./bootstrap');

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import Home from './pos/index.vue';
import Card from './pos/components/card.vue';

const app = createApp({});

app.component('home-component', Home);
app.component('card', Card);

app.mount("#pos");
