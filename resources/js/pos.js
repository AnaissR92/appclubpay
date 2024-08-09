import { createApp } from 'vue/dist/vue.esm-bundler.js';
import Home from './pages/pos/index.vue';
import NewPage from './pages/pos/new.vue';
import Card from './components/pos/card.vue';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp({});

app.component('VueDatePicker', VueDatePicker);

app.component('home-component', Home);
app.component('new-page', NewPage);
app.component('card', Card);
app.mount("#pos");
