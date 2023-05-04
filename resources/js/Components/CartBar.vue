<template>
    <v-row>
			<v-col cols="12">
        <v-toolbar
          elevation="3"
					color="#f9f7f7"
          rounded
         >
          <v-toolbar-title>
            <div class="d-flex">
              <div class="text-h5 my-auto">{{ title }}</div>
              <v-divider class="mx-4 my-1" vertical/>
              <div>
                <div>Всего предметов: <b>{{ totalItems() }}</b></div>
                <div>На общую стоимость: <b>{{ totalPrice() }}</b></div>
              </div>
            </div>
          </v-toolbar-title>
          <v-toolbar-items>
            <v-btn color="error"><v-icon icon="mdi-trash-can-outline" size="30"/></v-btn>
          </v-toolbar-items>
        </v-toolbar>
			</v-col>
		</v-row>
</template>

<script>
  export default {
    props: {
      entries: Object,
      title: String
    },

    data() {
      return {
        
      }
    },

    methods: {
      totalPrice() {
        let total = 0
        this.entries.forEach(item => {
          total += item.price * item.count
        })
        return total
      },
      totalItems() {
        let total = 0
        this.entries.forEach(item => {
          total += item.count
        })
        return total
      }

      
    }

  }
</script>

<style scoped>

</style>