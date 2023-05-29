<template>
	<Head title="Каталог"/>
	<MainLayout 
		:user="user"
		:cartUpdate="cartUpdate"
		@cartEndUpdate="cartUpdate = null"
	>
		<v-row>
			<v-col v-if="user?.admin" cols="12">
				<v-card class="pa-3" color="#f9f7f7" elevation="3">
					<div class="text-h5 mb-3">
						<span v-if="!productToChange">Добавить товар</span>
						<span v-else>Изменить товар</span>
					</div>
					<v-form v-model="form" @submit.prevent="!!productToChange ? updateProduct() : createProduct()">
						<v-row>
							<v-col cols="6">
								<v-text-field
									v-model="name"
									type="text"
									label="Название"
									color="#3F72AF"
									bg-color="#DBE2EF"
									variant="solo"
									density="comfortable"
									prepend-inner-icon="mdi-alphabetical-variant"
									hide-details
									required
									class="mb-3"
								/>
								<v-file-input
									v-model="image"
									:label="!!productToChange ? 'Изменить изображение' : 'Изображение'"
									color="#3F72AF"
									bg-color="#DBE2EF"
									variant="solo"
									density="comfortable"
									accept="image/*"
									prepend-inner-icon="mdi-image-area"
									prepend-icon
									hide-details
									:required="!!productToChange"
									clearable
									class="mb-3"
								/>
								<v-text-field
									v-model="price"
									type="tel"
									label="Цена"
									v-mask="['########']"
									color="#3F72AF"
									bg-color="#DBE2EF"
									variant="solo"
									density="comfortable"
									prepend-inner-icon="mdi-currency-rub"
									hide-details
									required
									class="mb-3"
								/>
								<Button v-if="!productToChange" type="submit">Добавить товар</Button>
								<template v-else>
									<Button type="submit">Сохранить изменения</Button>
									<InferiorBtn @click="cancel" class="ms-3">Отмена</InferiorBtn>
								</template>
							</v-col>
							<v-col cols="6">
								<v-textarea
									v-model="description"
									type="text"
									label="Описание"
									color="#3F72AF"
									bg-color="#DBE2EF"
									variant="solo"
									density="comfortable"
									hide-details
									required
									class="pb-6 h-100"
								/>
							</v-col>
						</v-row>
					</v-form>
				</v-card>
			</v-col>
			<template v-for="product in $page.props.products" :key="product.id">
				<v-col xl="3" md="4" sm="6" v-if="product.available == true">
					<v-hover v-slot="{ isHovering, props }">
						<v-card
							:elevation="isHovering ? 10 : 3"
							v-bind="props" 
							@click="router.get('/products/' + product.id)"
							class="text-center px-3 pt-1 pb-3 card" 
							variant="plain"
						>
							<div class="text-h6">{{ product.name }}</div>
							<img :src="'storage/' + product.image" class="my-1 w-100" style="aspect-ratio: 1 / 1;">
							<div class="text-h6">{{ product.price }}<Rub/></div>
							<v-divider class="mb-3"/>
							<Button 
                @click.stop="cartAddItem(product)"
                class="w-100 buy-btn" 
                :disabled="!user"
              >
                Добавить в корзину
              </Button>
							<v-row v-if="user?.admin" class="mt-0">
								<v-col cols="6" class="pe-2">
									<InferiorBtn class="w-100" @click.stop="editProduct(product)">Изменить</InferiorBtn>
								</v-col>
								<v-col cols="6" class="ps-2">
									<InferiorBtn class="w-100" @click.stop="deleteProduct(product)">Удалить</InferiorBtn>
								</v-col>
							</v-row>
						</v-card>
					</v-hover>
				</v-col>
			</template>
		</v-row>
	</MainLayout>
</template>

<script>
export default {
	data() {
		return {
			form: true,
			cartUpdate: null,
			name: null,
			image: null,
			price: null,
			description: null,
			productToChange: null,
		}
	},

	methods: {
		cartAddItem(product) {
  	  router.post('/cart/product', { id: product.id, }, { preserveState: true, preserveScroll: true })
  	  this.cartUpdate = { action: 'add', type: 'product', item: product } 
  	},

		clearForm() {
			this.name = null
			this.image = null
			this.price = null
			this.description = null
		},

		cancel() {
			this.productToChange = null
			this.clearForm()
		},

		createProduct() {
			if (!(this.name && this.image && this.price && this.description)) return
			router.post('/products', {
				name: this.name,
				image: this.image,
				price: this.price,
				description: this.description
			}, {
				preserveScroll: true,
				preserveState: true,
				forceFormData: true,
			}, {
				onFinish: this.clearForm()
			})
		},

		editProduct(product) {
			this.productToChange = product
			this.name = product.name
			this.price = product.price
			this.description = product.description
		},

		updateProduct() {
			if (!(this.name && this.price && this.description)) return
			router.post(`/products/${this.productToChange.id}`, {
				_method: 'patch',
				name: this.name,
				image: this.image,
				price: this.price,
				description: this.description
			}, {
				preserveState: true,
				preserveScroll: true,
				forceFormData: true,
			}, {
				onFinish: this.cancel()
			})
		},

		deleteProduct(product) {
			router.delete(`/products/${product.id}`, { preserveState: true, preserveScroll: true })
			if (product.id == this.productToChange?.id) this.cancel()
		}
	},
}
</script>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import MainLayout from '@/Layouts/MainLayout.vue'
import Button from '../Components/Button.vue'
import InferiorBtn from '../Components/InferiorBtn.vue'
import Rub from '../Components/Rub.vue'

defineProps({
  user: Object,
})

</script>

<style scoped>
.card{
	background-color: #f9f7f7;
	opacity: 1;
}

</style>