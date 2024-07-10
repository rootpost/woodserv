<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let invoices = ref([])
    let searchInvoice = ref([])

    onMounted(async () => {
        getInvoices()
    })

    const getInvoices = async () => {
        let response = await axios.get("/api/get_all_invoice")
        //console.log('response', response)
        invoices.value = response.data.invoices
    }

    const search = async () => {
        let response = await axios.get("/api/search_invoice?s="+searchInvoice.value)
        //console.log('response', response.data.invoices)
        invoices.value = response.data.invoices
    }

    const newInvoice = async () => {
        let form = await axios.get("/api/create_invoice")
        console.log('form', form.data)
        router.push('/invoice/new')
        //products.value = response.data.invoice
    }

    const onShow = async (id) => {
        //let form = await axios.get("/api/show_product")
        router.push('/invoice/show/'+id)
    }
</script>

<template>
    <div class="container">
        <h1>СЧЕТА</h1>
        <div class="blackline"></div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <button class="btn btn-primary" type="button" id="button-addon1" @click="newInvoice">НОВЫЙ</button>
            </div>
            <input type="text" class="form-control" size="40" placeholder="ПОИСК по ВСЕГО" v-model="searchInvoice" @keyup="search()">
        </div>
        <!--
        <button @click="newInvoice">НОВЫЙ</button>&nbsp;
        <input type="text" size="40" placeholder="ПОИСК" v-model="searchInvoice" @keyup="search()">
        -->
        <div class="blackline"></div>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Счет</th>
                <th scope="col">Заказчик</th>
                <th scope="col">Дата</th>
                <!--
                <th scope="col">№</th>
                <th scope="col">reference</th>
                <th scope="col">terms_and_conditions</th>
                -->
                <th scope="col">Сумма</th>
                <th scope="col">Скидка</th>
                <th scope="col">Всего</th>
                <th scope="col">Статус</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in invoices" :key="item.id" @click="onShow(item.id)">
                    
                    <th>{{ item.number }}</th>
                    <td>{{ item.customer.fl_name }}</td>
                    
                    <td>{{ new Date(item.date).toLocaleDateString() }}</td>
                    <!--
                    <td>{{ item.id }}</td>
                    <td>{{ item.date }}</td>
                    <td>{{ item.customer.fl_name }}</td>
                    <td>{{ item.reference }}</td>
                    <td>{{ item.terms_and_conditions }}</td>
                    -->
                    <td>{{ item.sub_total }}</td>
                    <td>{{ item.discount }}</td>
                    <td>{{ item.total }}</td>
                    <td>{{ item.status }}</td>
            </tr>
        </tbody>
    </table>
    </div>

</template>