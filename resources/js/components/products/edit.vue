<script setup>
    import { onMounted, ref } from "vue"
    import { useRouter } from "vue-router"

    const router = useRouter()

    let form = ref({ id:'' })

    const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })

    onMounted(async () => {
        getProduct()
    })

    const getProduct = async () => {
        let response = await axios.get(`/api/edit_product/${props.id}`)
        console.log('form', response.data.product)
        form.value = response.data.product
    }

    const back = () => {
        router.push('/products')
    }

    const onEdit = (id) => {
        
        const formData = new FormData()
        formData.append('item_code', form.value.item_code)
        formData.append('item_name', form.value.item_name)
        formData.append('description', form.value.description)
        formData.append('price', form.value.price)

        axios.post(`/api/update_product/${form.value.id}`, formData)
        
        router.push('/products')
    }

</script>
<template>
    <div class="container">
        <h2 class="invoice__title">РЕДАКТИРОВАНИЕ {{form.item_name}}</h2>
        <br>
        <div class="blackline"></div>
        <br>
        <div class="not_print">
            <a class="btn btn-secondary" onclick="window.history.back()">НАЗАД К СПИСКУ</a>&nbsp;
        </div>
        <br>
        <div class="blackline"></div>
        <br>
        <table class="product_table">
            <tr>
                <th>Код товара (артикул)</th>
                <td><input type="text" size="8" v-model="form.item_code"></td>
            </tr>
            <tr>
                <th>Наименование товара/услуги/работы</th>
                <td><input type="text" size="50" v-model="form.item_name"></td>
            </tr>
            <tr>
                <th>Адрес</th>
                <td><input type="text" size="50" v-model="form.description"></td>
            </tr>
            <tr>
                <th>Телефон</th>
                <td><input type="text" size="8" v-model="form.price"></td>
            </tr>
            
        </table>
        <br>
        <!--</div>-->
        <div>
            <a class="btn btn-secondary" @click="onEdit(form.id)">СОХРАНИТЬ</a>
            &nbsp;
            <a class="btn btn-secondary" @click="back()">ОТМЕНА</a>
        </div>
        <br>
        <div class="blackline"></div>
        <br>
    </div>
</template>