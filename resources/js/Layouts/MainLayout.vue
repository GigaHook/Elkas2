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

            <v-btn
              v-if="!!user"
              class="rounded-0 cart-btn ms-auto" 
              :class="{ 'active': $page.url === '/cart' }"
              style="height:100%; max-width:48px" 
              @click="router.get('/cart')"
              size="small"
            >
              <v-badge
                v-if="$root.cartBadge"
                color="red"
                dot
              >
                <v-icon icon="mdi-cart-outline" size="32"/>
              </v-badge>
              <v-icon v-else icon="mdi-cart-outline" size="32"/>
            </v-btn>
            
            <v-btn
              v-else
              class="rounded-0 cart-btn ms-auto" 
              :class="{ 'active': $page.url === '/cart' }"
              style="height:100%; max-width:48px" 
              @click="router.get('/cart')"
              size="small"
              disabled
            >
              <v-icon icon="mdi-cart-outline" size="32"/>
            </v-btn>

            <!--<v-btn 
              v-else
              class="rounded-0 cart-btn ms-auto" 
              icon="mdi-cart-outline" 
              style="height:100%; width:48px" 
              size="x-large" 
              disabled
            />-->
          
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
              <InferiorBtn
                @click="formVariant = !formVariant" 
                append-icon="mdi-arrow-right" 
                class="mt-1"
              >
                Зарегистрироваться
              </InferiorBtn>
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
              <InferiorBtn
                @click="formVariant = !formVariant" 
                append-icon="mdi-arrow-right" 
                class="mt-1"
              >
                Войти
              </InferiorBtn>
            </v-form>
          </v-card>
        </v-scroll-x-transition>
        <!--cart data-->
        <v-card v-if="$page.url === '/cart'" class="pa-3 mt-6" color="#f9f7f7" elevation="3">
          <div class="text-h5 mb-1">
            Корзина
          </div>
          Всего предметов в корзине: {{ cartData.totalItems }} <br>
          На общую стоимость: {{ cartData.totalPrice }}
          <div class="d-flex align-end justify-between">
            <Button @click="makeOrder" class="mt-2" :disabled="cartData.totalItems == 0">Оформить заказ</Button>
            <InferiorBtn @click="$emit('cartClear')">Очистить</InferiorBtn>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <!--footer-->
    <v-card class="mt-4" color="#DBE2EF">
      <v-container>
        <v-row>
			  	<v-col cols="3">
			  		<v-icon icon="mdi-map"/>
			  		г. Канск <br>
			  		<v-icon icon="mdi-map-marker-radius"/>
            ул. Пролетарская <br>
            <v-icon icon="mdi-map-marker"/>
			  		д. 34, офис 65
			  	</v-col>
			  	<v-col cols="3">
			  		<v-icon icon="mdi-email-outline"/>
            elkas.kansk@mail.ru
			  	</v-col>
			  	<v-col cols="3">
			  		<v-icon icon="mdi-phone"/>
			  		+7 (39161) 3-23-81 <br>
            <v-icon icon="mdi-phone"/>
			  		+7 (39161) 6-35-00
			  	</v-col>
			  	<v-col cols="3">
            <v-icon icon="mdi-timetable"/>
            Понедельник - Пятница <br>
            <v-icon icon="mdi-clock-outline"/>
            09:00 - 17:00
			  	</v-col>
			  </v-row>
      </v-container>
    </v-card>

  </v-app>
</template>

<script>
export default {
  props: {
    user: Object,
    cartData: {
      type: Object,
      default: null,
    },
  },

  watch: {
    '$page.props.cart': {
      handler() {
        if (this.$page.url !== '/cart') this.$root.cartBadge = true
      },
      deep: true
    },

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
    }
  },

  methods: {
    clearForms() {
      setTimeout(function() {
        this.loginEmail = ''
        this.loginPassword = ''
        this.registerEmail = ''
        this.registerPassword = ''
        this.registerName = ''
        this.registerNumber = ''
        this.repeat = ''
      }.bind(this), 1000)
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
          onSuccess: this.clearForms()
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
          onSuccess: this.clearForms(),
        })
      }
    },

    logout() {
      router.post(route('logout'), {
        preserveState: true,
        preserveScroll: true,
      })
    },

    makeOrder() {
      router.post(route('order.make'), {
        products: this.$page.props.cart.products,
        services: this.$page.props.cart.services,
      }, {
        preserveScroll: true,
        preserveState: true,
        onFinish: setTimeout(function() {
          this.$emit('cartClear')
        }.bind(this), 1000)
      })
    }

  }


}
</script>

<script setup>
import { router } from '@inertiajs/vue3'
import Button from '../Components/Button.vue'
import NavItem from '../Components/NavItem.vue'
import InferiorBtn from '../Components/InferiorBtn.vue'

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
