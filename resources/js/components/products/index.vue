<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let products = ref([])
    let searchProduct = ref([])


    onMounted(async () => {
        getProducts()
    })

    const getProducts = async () => {
        let response = await axios.get("/api/get_all_product")
        //console.log('response', response)
        products.value = response.data.products
    }

    const search = async () => {
        let response = await axios.get("/api/search_product?s="+searchProduct.value)
        //console.log('response', response.data.products)
        products.value = response.data.products
    }

    const newProduct = async () => {
        let form = await axios.get("/api/create_product")
        //console.log('form', form)
        router.push('/product/new')
    }

    const onShow = async (id) => {
        let form = await axios.get("/api/show_product")
        router.push('/product/show/'+id)
    }
</script>

<template>
    <div class="container">
        <h1>ТОВАРЫ УСЛУГИ</h1>
        <div class="blackline"></div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" id="button-addon1" @click="newProduct">НОВЫЙ</button>
            </div>
            <input type="text" class="form-control" size="40" placeholder="ПОИСК" v-model="searchProduct" @keyup="search()">
            
        </div>
        <!--
        <a class="btn btn-secondary" @click="newProduct">НОВЫЙ</a>
        <input type="text" class="form-control" size="40" placeholder="ПОИСК" v-model="searchProduct" @keyup="search()">
        <input type="text" class="form-control" size="40" placeholder="ПОИСК" v-model="searchProduct" @keyup="search()">
        -->
        <div class="blackline"></div>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
            <th scope="col">id</th>
            <th scope="col">Артикул</th>
            <th scope="col">Наименование</th>
            <th scope="col">Цена</th>
            </tr>
        </thead>
        <tbody class="text-break">
            <tr v-for="item in products" :key="item.id" @click="onShow(item.id)">
                <th scope="row">{{ item.id }}</th>
                <td>{{ item.item_code }}</td>
                <td><p>{{ item.item_name }}</p></td>
                <td>{{ item.price }}р.</td>
            </tr>
        </tbody>
    </table>

    </div>

</template>