<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let customers = ref([])
    let searchCustomer = ref([])


    onMounted(async () => {
        getCustomer()
    })

    const getCustomer = async () => {
        let response = await axios.get("/api/customers")
        //console.log('response', response)
        customers.value = response.data.customers
    }

    const search = async () => {
        let response = await axios.get("/api/search_customer?s="+searchCustomer.value)
        //console.log('response', response.data.customers)
        customers.value = response.data.customers
    }

    const newCustomer = async () => {
        let form = await axios.get("/api/create_customer")
        //console.log('form', form)
        router.push('/customer/new')
    }

    const onShow = async (id) => {
        let form = await axios.get("/api/show_customer")
        router.push('/customer/show/'+id)
    }
</script>

<template>
    <div class="container">
        <h1>ЗАКАЗЧИКИ</h1>
        <div class="blackline"></div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" id="button-addon1" @click="newCustomer">НОВЫЙ</button>
            </div>
            <input type="text" class="form-control" size="40" placeholder="ПОИСК" v-model="searchCustomer" @keyup="search()">
        </div>
        <!--
        <button @click="newCustomer">НОВЫЙ</button>&nbsp;
        <input type="text" size="40" placeholder="ПОИСК" v-model="searchCustomer" @keyup="search()">
        -->
        <div class="blackline"></div>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
            <th scope="col">id</th>
            <th scope="col">Краткое название</th>
            <th scope="col">Полное название</th>
            <th scope="col">Телефон</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in customers" :key="item.id" @click="onShow(item.id)">
                <th scope="row">{{ item.id }}</th>
                <td>{{ item.fl_name }}</td>
                <td>{{ item.full_name }}</td>
                <td><p>{{ item.phone }}</p></td>
            </tr>
        </tbody>
    </table>

    </div>

</template>