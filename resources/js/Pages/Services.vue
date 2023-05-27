<template>
	<Head title="Каталог"/>
	<MainLayout 
		:user="user"
		:cartUpdate="cartUpdate"
		@cartEndUpdate="cartUpdate = null"
	>
		<v-row>
			<v-col cols="12">
				<v-card v-if="user?.admin" class="pa-3" color="#f9f7f7" elevation="3">
					<div class="text-h5 mb-3">
						<span v-if="!serviceToChange">Добавить услугу</span>
						<span v-else>Изменить услугу</span>
					</div>
					<v-form v-model="form" @submit.prevent>
						<v-row>
							<v-col cols="6">
								<v-text-field
									v-model="name"
									:rules="[rules.required]"
									validate-on="input"
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
									:label="serviceToChange ? 'Изменить изображение' : 'Изображение'"
									color="#3F72AF"
									bg-color="#DBE2EF"
									variant="solo"
									density="comfortable"
									accept="image/*"
									prepend-inner-icon="mdi-image-area"
									prepend-icon
									hide-details
									:required="!!serviceToChange"
									clearable
									class="mb-3"
								/>
								<v-text-field
									v-model="price"
									:rules="[rules.required]"
									validate-on="input"
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
								<Button v-if="!serviceToChange" @click="createService" type="submit">Добавить услугу</Button>
								<template v-else>
									<Button @click="updateService" type="submit">Сохранить изменения</Button>
									<InferiorBtn @click="cancel" class="ms-3" type="submit">Отмена</InferiorBtn>
								</template>
							</v-col>
							<v-col cols="6">
								<v-textarea
									v-model="description"
									:rules="[rules.required]"
									validate-on="input"
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
			<template v-for="service in $page.props.services" :key="service.id">
				<v-col xl="3" md="4" sm="6" v-if="service.available == true">
					<v-hover v-slot="{ isHovering, props }">
						<v-card
							:elevation="isHovering ? 10 : 3"
							v-bind="props" 
							@click="router.get('/services/' + service.id)"
							class="text-center px-3 pt-1 pb-3 card" 
							variant="plain"
						>
							<div class="text-h6">{{ service.name }}</div>
							<img :src="'storage/' + service.image" class="my-1 w-100" style="aspect-ratio: 1 / 1;">
							<div class="text-h6"><Rub/>{{ service.price }}</div>
							<v-divider class="mb-3"/>
							<Button 
                @click.stop="cartAddItem(service)"
                class="w-100 buy-btn" 
                :disabled="!user"
              >
                Добавить в корзину
              </Button>
							<v-row v-if="user?.admin" class="mt-0">
								<v-col cols="6" class="pe-2">
									<InferiorBtn class="w-100" @click.stop="editService(service)">Изменить</InferiorBtn>
								</v-col>
								<v-col cols="6" class="ps-2">
									<InferiorBtn class="w-100" @click.stop="deleteService(service)">Удалить</InferiorBtn>
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
			form: false,
			cartUpdate: null,
			name: null,
			image: null,
			price: null,
			description: null,
			serviceToChange: null,
			rules: {
				required: value => !!value || "Это обязательное поле"
			},
		}
	},

	methods: {
		cartAddItem(service) {
  	  router.post('/cart/service', { id: service.id, }, { preserveState: true, preserveScroll: true })
  	  this.cartUpdate = { action: 'add', type: 'service', item: service } 
  	},

		clearForm() {
			this.name = null,
			this.image = null,
			this.price = null,
			this.description = null
		},

		cancel() {
			this.serviceToChange = null
			this.clearForm()
		},

		createService() {
			if (!(!!this.name && !!this.image && !!this.price && !!this.description)) return
			router.post('/services', {
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

		editService(service) {
			this.serviceToChange = service
			this.name = service.name
			this.price = service.price
			this.description = service.description
		},

		updateService() {
			if (!(!!this.name && !!this.price && !!this.description)) return
			router.post(`/services/${this.serviceToChange.id}`, {
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
		
		deleteService(service) {
			router.delete(`/services/${service.id}`, { preserveState: true, preserveScroll: true })
		}
	},
}
</script>

<script setup>
import { Head, router} from '@inertiajs/vue3'
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