import { createApp } from 'vue/dist/vue.esm-bundler.js';
import Home from './pos/pages/index.vue';
import NewPage from './pos/pages/new.vue';
import Card from './pos/components/card.vue';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const app = createApp({});

app.component('VueDatePicker', VueDatePicker);

app.component('home-component', Home);
app.component('new-page', NewPage);
app.component('card', Card);
app.mount("#pos");
