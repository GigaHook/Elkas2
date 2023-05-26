<template>
  <v-app>

    <v-container style="height: 44px; background-color: #DBE2EF;" class="w-100">
      <v-app-bar class="d-flex align-center" color="#DBE2EF" style="max-height:48px;" density="compact" elevation="3">
        <v-row class="justify-center">
          <v-col lg="12" xl="11" class="ps-6 pe-5 d-flex">
            <img :src="'../storage/assets/logo_variant_3.png'" style="height:48px; max-width: 290px;" class="pe-2">

            <NavItem route="/">Главная</NavItem>
            <NavItem route="/products">Каталог</NavItem>
            <NavItem route="/services">Услуги</NavItem>
            <NavItem route="/contacts">Контакты</NavItem>
            <NavItem route="/about">О нас</NavItem>
            <NavItem route="/orders" :disabled="!user">Заказы</NavItem>

            <Link v-if="!!user" href="/cart" class="ms-auto">
              <v-btn
                class="rounded-0 cart-btn " 
                :class="{ 'active': $page.url === '/cart' }" 
                icon="mdi-cart-outline" 
                style="height:100%; width:48px" 
                size="x-large"
              />
            </Link>
          
            <span v-else class="ms-auto">
              <v-btn 
                class="rounded-0 cart-btn" 
                icon="mdi-cart-outline" 
                style="height:100%; width:48px" 
                size="x-large" 
                disabled
              />
            </span>
          </v-col>
        </v-row>
      </v-app-bar>
    </v-container>

    <v-row class="justify-center mt-3 mx-md-1 mx-xl-0">
      <!--content-->
      <v-col lg="9" md="9" sm="12">
        <slot/>
      </v-col>
      <!--side-->
      <v-col xl="2" lg="3" md="3" sm="12">
        <v-scroll-x-transition leave-absolute>
          <!--auth-->
          <v-card v-if="!!user" class="pa-3" color="#f9f7f7" elevation="3">
            <div class="d-flex flex-column">
              <v-icon icon="mdi-account-check-outline" size="100" class="align-self-center"/>
              <div class="text-h6 align-self-center mb-2">
                {{ user.name }}
              </div>
              <Button @click="logout" class="mt-2 align-self-center">Выйти</Button>
            </div>
          </v-card>
          <!--guest-->
          <v-card v-else-if="formVariant" class="pa-3" color="#f9f7f7" elevation="3">
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
                prepend-inner-icon="mdi-email"
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
                prepend-inner-icon="mdi-lock"
                required
              />
              <Button type="submit" class="mb-3">Войти</Button> <br>
              Нет аккаунта? <br>
              <v-btn 
                variant="text" 
                @click="formVariant = !formVariant" 
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
                prepend-inner-icon="mdi-account"
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
                prepend-inner-icon="mdi-email"
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
                prepend-inner-icon="mdi-cellphone"
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
                prepend-inner-icon="mdi-lock"
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
                prepend-inner-icon="mdi-lock-reset"
                required
              />
              <Button type="submit" class="mb-3">Зарегистрироваться</Button> <br>
              Есть аккаунт? <br>
              <v-btn 
                variant="text" 
                @click="formVariant = !formVariant" 
                append-icon="mdi-arrow-right" 
                v-ripple="{ class: `text-info` }"
                class="mt-1"
              >
                Войти
              </v-btn>
            </v-form>
          </v-card>
        </v-scroll-x-transition>
        <!--cart data-->
        <v-card v-if="$page.url === '/cart'" class="pa-3 mt-6" color="#f9f7f7" elevation="3">
          Всего товаров в корзине: TODO
          <Button @click="makeOrder">Оформить заказ</Button>
        </v-card>
      </v-col>
    </v-row>

    <v-snackbar 
      v-model="feedback" 
      :timeout="feedbackTimeOut"
      color="#f9f7f7"
    >
      <div style="color:black" class="d-flex align-center">
        <v-icon :color="feedbackColor" :icon="feedbackIcon" size="30" class="me-2"/>
        {{ feedbackText }}
      </div>
      <template v-slot:actions>
        <v-btn @click="feedback = false" variant="plain" color="black">
          <v-icon icon="mdi-close"/>
        </v-btn>
      </template>
    </v-snackbar>

  </v-app>
</template>

<script>
export default {
  props: {
    user: Object,
    cartUpdate: Object,
    cartData: {
      type: Object,
      default: null,
    }
  },

  watch: {
    cartUpdate(data) {
      if (!data) return
      let text
      let icon
      switch (data.action) {
        case 'add': 
          text = data.type == 'product'
          ? `Товар ${data.item.name} добавлен в корзину`
          : `Услуга ${data.item.name} добавлена в корзину`
          icon = 'mdi-cart-arrow-down'
          break
        case 'delete':
          text = data.type == 'product'
          ? `Товар ${data.item.name} удалён из корзины`
          : `Услуга ${data.item.name} удалена из корзины`
          icon = 'mdi-cart-remove'
          break
        case 'clear':
          text = data.type == 'product'
          ? 'Товары убраны из корзины'
          : 'Услуги убраны из корзины'
          icon = 'mdi-cart-remove'
          break
        default: break
      }
      this.notify(text, icon)
      this.$emit('cartEndUpdate')
    }
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
      formVariant: true,
      isLoginValid: true,
      isRegisterValid: true,
      //notification
      feedback: false,
      feedbackIcon: '',
      feedbackText: '',
      feedbackColor: '',
      feedbackTimeout: 0,
    }
  },

  computed: {
    cartTotal() {
      return ''
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

    notify(text, icon='mdi-information-outline', color='info') {
      this.feedbackTimeout = 0
      this.feedbackText = text
      this.feedbackIcon = icon
      this.feedbackColor = color
      this.feedbackTimeout = 4000
      this.feedback = true
    },

    loginSubmit() {
      if (this.isLoginValid) {
        router.post(route('login'), {
          email: this.loginEmail,
          password: this.loginPassword,
          remember: true,
        }, {
          preserveState: true,
          preserveScroll: true,
          onSuccess: () => {
            this.notify('Вы вошли в аккаунт', 'mdi-account-check-outline', 'success')
            this.clearForms()
          },
          onError: () => this.notify('Неверный логин или пароль', 'mdi-account-remove-outline', 'red-darken-2')
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
        }, {
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => {
            this.notify('Вы успешно зарагистрировались', 'mdi-account-plus-outline', 'success')
            this.clearForms()
          },
          onError: () => this.notify('Ошибка. Проверьте ваши данные', 'mdi-account-remove-outline', 'red-darken-2')
        })
      }
    },

    logout() {
      router.post(route('logout'), {
        preserveState: true,
        preserveScroll: true,
        onFinish: this.notify('Вы вышли из аккаунта')
      })
    },

    makeOrder() {
      router.post(route('order.make'), {
        products: this.$page.props.cart.products,
        services: this.$page.props.cart.services,
      }, {
        preserveScroll: true,
        preserveState: true,
      })
    }

  }


}
</script>

<script setup>
import { Link, Head, router } from '@inertiajs/vue3'
import Button from '../Components/Button.vue'
import NavItem from '../Components/NavItem.vue'

</script>

<style scoped>
.cart-btn {
  color: #112D4E;
  transition: all .1s ease-in-out;
}
.cart-btn:hover{
  background-color: #3F72AF;
  color: #DBE2EF;
}
.active, .active:hover{
  background-color: #F38307;
  color: white;
  box-shadow: 0px 0px 20px 3px rgba(243, 131, 7, .6);
  z-index: 2;
}
</style>
