<template>
  <v-app>

    <v-container style="height: 44px;">
      <v-app-bar class="justify-center" color="#DBE2EF" style="height: 44px;">
        <Link class="nav-item" href="/"><v-btn class="rounded-0 nav-item">Главная</v-btn></Link>
        <Link class="nav-item" href="/catalogue"><v-btn class="rounded-0 nav-item">Каталог</v-btn></Link>
        <!--<Link class="nav-item"><v-btn class="rounded-0 nav-item">Услуги</v-btn></Link>
        <Link class="nav-item"><v-btn class="rounded-0 nav-item">О нас</v-btn></Link>
        <Link class="nav-item me-auto"><v-btn class="rounded-0 nav-item">Контакты</v-btn></Link>
        <Link class="nav-item cart-btn"><v-btn class="rounded-0 nav-item">крзн</v-btn></Link>-->
      </v-app-bar>
    </v-container>

    <v-row class="justify-center mt-4">
      <!--content-->
      <v-col xl="7" lg="8" md="8" sm="12">
        <v-card class="block py-1 px-3" elevation="3">
          <slot />
        </v-card>
      </v-col>
      <!--side-->
      <v-col xl="2" lg="3" md="4" sm="12">
        <!--auth-->
        <div v-if="!!user">
          <v-card class="block py-1 px-3" elevation="3">
            {{ user.name }} <br>
            <Link :href="route('logout')" method="post"><v-btn>Выйти</v-btn></Link>
          </v-card>
        </div>
        <!--guest-->
        <div v-else>
          <v-card class="block py-1 px-3" elevation="3">
            <form @submit.prevent="submit" id="form">
              <input type="email" name="email" v-model="email"><br>
              <input type="password" name="password" v-model="password"><br>
              <input type="checkbox" name="remember" v-model="remember"><br>
              <button type="submit">login</button>
              
            </form>
            <Link as="button" type="button" :href="route('login')" method="post" :data="{email: 'asd@asd.asd',
    password: 'asdasdasd',
    remember: false}" preserve-state="">lgn</Link>

            <!--<div v-if="status" class="mb-4 font-medium text-sm text-green-600">
              {{ status }}
            </div>

            <form @submit.prevent="submit">
              <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                  autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
              </div>

              <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                  autocomplete="current-password" />

                <InputError class="mt-2" :message="form.errors.password" />
              </div>

              <div class="block mt-4">
                <label class="flex items-center">
                  <Checkbox name="remember" v-model:checked="form.remember" />
                  <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
              </div>

              <div class="flex items-center justify-end mt-4">


                
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Log in
                </PrimaryButton>
              </div>
            </form>-->


          </v-card>
        </div>

      </v-col>
    </v-row>

  </v-app>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3';

import { Axios } from 'axios';

import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { router } from '@inertiajs/vue3'

defineProps({
  user: Object,
  status: String,
});

//form
//const form = useForm({
//  email: '',
//  password: '',
//  remember: false,
//})

let email = ''
let password = ''
let remember = false

const submit = () => {

  //router.post(route('login'), {
  //  email: email,
  //  password: password,
  //  remember: remember
  //}, { only: ['user'] })
  

  //form.post(route('login'), {
  //  onFinish: () => form.reset('password'),
  //});
}





</script>

<style scoped>
.block {
  background-color: #f9f7f7;
}






.nav-item:hover {
  background-color: #3F72AF;
  color: #DBE2EF;
}

.nav-item {
  color: #112D4E;
  font-weight: 600;
  width: 100px;
  height: 100%;
  transition: all .1s ease-in-out;
}

.cart-btn {
  width: fit-content;
}

:deep(.v-btn--active > .v-btn__overlay) {
  /*magic 1*/
  opacity: 0;
}

:deep(.v-btn--active > .v-btn__underlay) {
  /*magic 2*/
  background-color: #F38307;
  z-index: -1;
}
</style>