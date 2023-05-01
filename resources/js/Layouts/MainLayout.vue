<template>
  <v-app>

    <v-container style="height: 44px;">
      <v-app-bar class="justify-center" color="#DBE2EF" style="height: 44px;" elevation="3">
        <Link class="nav-item" href="/"><v-btn class="rounded-0 nav-item">Главная</v-btn></Link>
        <Link class="nav-item" href="/products"><v-btn class="rounded-0 nav-item">Каталог</v-btn></Link>
        <Link class="nav-item" href="/services"><v-btn class="rounded-0 nav-item">Услуги</v-btn></Link>
        <Link class="nav-item"><v-btn class="rounded-0 nav-item">О нас</v-btn></Link>
        <Link class="nav-item me-auto"><v-btn class="rounded-0 nav-item">Контакты</v-btn></Link>
        <Link class="nav-item cart-btn"><v-btn class="rounded-0 nav-item cart-btn"><v-icon icon="mdi-cart-outline" size="30"/></v-btn></Link>
      </v-app-bar>
    </v-container>

    <v-row class="justify-center mt-3 mx-md-1 mx-lg-0">
      <!--content-->
      <v-col xl="7" lg="8" md="9" sm="12">
        <slot/>    
        
      </v-col>
      <!--side-->
      <v-col xl="2" lg="3" md="3" sm="12">
        <v-scroll-x-transition hide-on-leave>
          <!--auth-->
          <v-card v-if="!!user" class="pa-3" color="#f9f7f7" elevation="3">
            <span>Статус: <b>Авторизованный пользователь</b></span>
            <div class="d-flex flex-column">
              <v-icon icon="mdi-account-check-outline" size="100" class="align-self-center"/>
              <div class="text-h6 align-self-center mb-2">
                {{ user.name }}
              </div>
              Товаров в корзине: TODO <br>
              <Link class="align-self-center"><v-btn variant="tonal" append-icon="mdi-arrow-right" style="color:black" v-ripple="{ class: `text-info` }">В корзину</v-btn></Link>
              <Button @click="logout" class="mt-2 align-self-center">Выйти</Button>
            </div>
          </v-card>
          <!--guest-->
          <v-card v-else-if="loginVariant" class="pa-3" color="#f9f7f7" elevation="3">
            <span>Статус: <b>Гость</b></span>
            <v-form @submit.prevent="loginSubmit" v-model="isLoginValid" validate-on="blur" class="text-center">
              <v-icon icon="mdi-account-remove-outline" style="transform: scaleX(-1);" size="100"/> <!--mirror magic-->
              <div class="text-h6 mb-3">Войдите в аккаунт</div>
              <v-text-field
                type="email"
                v-model="loginEmail"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                color="#3F72AF"
                bg-color="#DBE2EF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="password"
                v-model="loginPassword"
                :rules="[rules.required, rules.range]"
                label="Пароль"
                hint="От 8 до 20 символов"
                color="#3F72AF"
                bg-color="#DBE2EF"
                variant="solo"
                density="comfortable"
                required
              />
              <Button type="submit" class="mb-3">Войти</Button> <br>
              Нет аккаунта? <br>
              <v-btn 
                variant="text" 
                @click="loginVariant = !loginVariant" 
                append-icon="mdi-arrow-right" 
                v-ripple="{ class: `text-info` }"
                class="mt-1"
              >
                Зарегистрироваться
              </v-btn>
            </v-form>
          </v-card>
          <!--register-->
          <v-card v-else class="pa-3" color="#f9f7f7" elevation="3">
            <v-form @submit.prevent="registerSubmit" v-model="isRegisterValid" validate-on="blur" class="text-center">
              <div class="text-h6 mb-3">Регистрация</div>
              <v-text-field
                type="text"
                v-model="registerName"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Логин"
                placeholder="IvanovIvan"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="email"
                v-model="registerEmail"
                :rules="[rules.required, rules.email]"
                label="E-mail"
                placeholder="example@gmail.com"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="tel"
                v-model="registerNumber"
                :rules="[rules.required]"
                v-mask="[' (###) ###-##-##']"
                label="Телефон"
                placeholder="(555) 555-55-55"
                prefix="+7 "
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="password"
                v-model="registerPassword"
                :rules="[rules.required, rules.range]"
                maxlength="20"
                label="Пароль"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <v-text-field
                type="password"
                v-model="repeat"
                :rules="[rules.required, rules.repeat]"
                maxlength="20"
                label="Повторите пароль"
                hint="От 8 до 20 символов"
                bg-color="#DBE2EF"
                color="#3F72AF"
                variant="solo"
                density="comfortable"
                required
              />
              <Button type="submit" class="mb-3">Зарегистрироваться</Button> <br>
              Есть аккаунт? <br>
              <v-btn 
                variant="text" 
                @click="loginVariant = !loginVariant" 
                append-icon="mdi-arrow-right" 
                v-ripple="{ class: `text-info` }"
                class="mt-1"
              >
                Войти
              </v-btn>
            </v-form>
          </v-card>
        </v-scroll-x-transition>
      </v-col>
    </v-row>
  </v-app>
</template>

<script>
export default {
  props: {
    user: Object,
    page: String,
    title: String,
    product: Object,
    service: Object,
  },

  data() {
    return {
      loginEmail: '',
      loginPassword: '',
      registerEmail: '',
      registerPassword: '',
      registerName: '',
      registerNumber: '',
      repeat: '',
      rules: {
        required: value => !!value || "Это обязательное поле",
        email: value => (value.includes('@') && value.includes('.')) || "Неправильная почта",
        range: value => (value.length >= 8 && value.length <= 20) || "От 8 до 20 символов",
        repeat: value => (value === this.registerPassword) || 'Пароли не совпадают'
      },
      loginVariant: true,
      isLoginValid: true,
      isRegisterValid: true,
    }
  },

  methods: {
    clearForms() {
      this.loginEmail = ''
      this.loginPassword = ''
      this.registerEmail = ''
      this.registerPassword = ''
      this.registerName = ''
      this.registerNumber = ''
      this.repeat = ''
    },

    loginSubmit() {
      if (this.isLoginValid) {
        router.post(route('login'), {
          email: this.loginEmail,
          password: this.loginPassword,
          remember: true,
          page: this.page,
          product: this.product,
          service: this.service, 
        }, {
          preserveState: true,
          preserveScroll: true,
          onSuccess: () => {
            this.clearForms()
          }
        })
      }
    },

    registerSubmit() {
      if (this.isRegisterValid) {
        router.post(route('register'), {
          email: this.registerEmail,
          password: this.registerPassword,
          name: this.registerName,
          number: this.registerNumber,
          page: this.page,
          product: this.product,
          service: this.service,
        }, {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => {
            this.clearForms()
          }
        })
      }
    },

    logout() {
      router.post(route('logout'), {
        page: this.page,
        product: this.product,
        service: this.service,
      }, {
        preserveState: true,
        preserveScroll: true
      })
    },


  }


}
</script>

<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import Button from '../Components/Button.vue'

</script>

<style scoped>
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
