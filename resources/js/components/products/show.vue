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
        let response = await axios.get(`/api/show_product/${props.id}`)
        //console.log('form', response.data.product)
        form.value = response.data.product
    }
    
    const onEdit = (id) => {
        router.push('/product/edit/'+id)
    }
    
    const deleteProduct = (id) => {
        axios.get('/api/delete_product/'+id)
        router.push('/products')
    }

</script>

<template>
    <div class="container">
        <div class="blackline"></div>
        <div class="not_print">
            <a class="btn btn-secondary" onclick="window.history.back()">НАЗАД К СПИСКУ</a>&nbsp;
            <a class="btn btn-secondary" @click="onEdit(form.id)">ИЗМЕНИТЬ</a>&nbsp;
            <a class="btn btn-secondary" @click="deleteProduct(form.id)">УДАЛИТЬ</a>
        </div>
        <div class="blackline"></div>
        <table class="product_table">
            <tr>
                <th>Артикул</th>
                <td>{{form.item_code}}</td>
            </tr>
            <tr>
                <th>Наименование</th>
                <td>{{form.item_name}}</td>
            </tr>
            <tr>
                <th>Описание</th>
                <td>{{form.description}}</td>
            </tr>
            <tr>
                <th>Цена</th>
                <td>{{form.price}}</td>
            </tr>
        </table>
        <div class="blackline"></div>
    </div>
</template>