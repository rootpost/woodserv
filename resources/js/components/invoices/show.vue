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
        getInvoice()
    })

    const getInvoice = async () => {
        let response = await axios.get(`/api/show_invoice/${props.id}`)
        console.log('form', response.data.invoice)
        form.value = response.data.invoice
    }

    const print = () => {
        window.print()
        router.push('/invoices').catch(() => {})
    }

    const onEdit = (id) => {
        router.push('/invoice/edit/'+id)
    }

    const deleteInvoice = (id) => {
        axios.get('/api/delete_invoice/'+id)
        router.push('/invoices')
    }

    const back = () => {
        router.push('/invoices')
    }

</script>

<template>
    <div class="container">
        <div class="not_print">
            <div class="blackline"></div>
            <a class="btn btn-secondary" onclick="window.history.back()">НАЗАД К СПИСКУ</a>&nbsp;
            <a class="btn btn-secondary" @click="onEdit(form.id)">ИЗМЕНИТЬ</a>&nbsp;
            <a class="btn btn-secondary" @click="deleteInvoice(form.id)">УДАЛИТЬ</a>&nbsp;
            <a class="btn btn-secondary" onclick="window.print()">ПЕЧАТЬ</a>&nbsp;
            <!--<button @click="print()">ПЕЧАТЬ2</button>-->
            
            <div class="blackline"></div>
        </div>

        <div id="print_invoice">
            <table width="100%">
                <tr>
                    <!--
                    <td>&nbsp;</td>
                    <td style="width: 155mm;">
                        <div style="width:155mm; ">Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате  обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.</div>
                    </td>
                    -->
                    <td>&nbsp;</td>
                    <td>
                        <div style="width: 850px;text-align: center;font-size:11pt;">Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате  обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и паспорта.</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div style="text-align:center;  font-weight:bold;">
                            Образец заполнения платежного поручения                                                                                                                                            </div>
                    </td>
                </tr>
            </table>

            <table width="100%" cellpadding="2" cellspacing="2" class="invoice_bank_rekv">
                <tr>
                    <td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
                            <tr>
                                <td valign="top">
                                    <div>АО «РОССЕЛЬХОЗБАНК»</div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="bottom" style="height: 3mm;">
                                    <div style="font-size:10pt;">Банк получателя        </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="min-height:7mm;height:auto; width: 25mm;">
                        <div>БИK</div>
                    </td>
                    <td rowspan="2" style="vertical-align: top; width: 60mm;">
                        <div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">044525111</div>
                        <div>30101810200000000111</div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25mm;">
                        <div>Сч. №</div>
                    </td>
                </tr>
                <tr>
                    <td style="min-height:6mm; height:auto; width: 50mm;">
                        <div>ИНН 322700054292</div>
                    </td>
                    <td style="min-height:6mm; height:auto; width: 55mm;">
                        <div>КПП </div>
                    </td>
                    <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
                        <div>Сч. №</div>
                    </td>
                    <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
                        <div>Расчетный счет</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="min-height:13mm; height:auto;">

                        <table border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
                            <tr>
                                <td valign="top">
                                    <div>ИП Довгалев Михаил Михайлович</div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="bottom" style="height: 3mm;">
                                    <div style="font-size: 10pt;">Получатель</div>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
            <br/>

            <div style="font-weight: bold; font-size: 17pt; padding-left:5px;">
                Счет № {{form.number}} от {{new Date(form.date).toLocaleDateString()}}</div>
            <br />

            <div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>

            <table width="100%">
                <tr>
                    <td style="width: 30mm;">
                        <div style=" padding-left:2px;">Поставщик:    </div>
                    </td>
                    <td>
                        <div style="font-weight:bold;  padding-left:2px;width: 850px;">
                            Индивидуальный предприниматель Довгалев Михаил Михайлович, ИНН 322700054292, Брянская область, Стародубский район, село Меленск            </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 30mm;">
                        <div style=" padding-left:2px;">Покупатель:    </div>
                    </td>
                    <td>
                        <div style="font-weight:bold;  padding-left:2px;" v-if="form.customer">
                            {{form.customer.full_name}}            </div>
                    </td>
                </tr>
            </table>


            <table class="invoice_items" width="100%" cellpadding="2" cellspacing="2">
                <thead>
                    <tr>
                        <th style="width:13mm;text-align: center;">№</th>
                        <!--<th style="width:20mm;text-align: center;">Код</th>-->
                        <th>Наименование товара, работ, услуг</th>
                        <th style="width:20mm;text-align: center;">Кол-во</th>
                        <!--<th style="width:17mm;">Ед.</th>-->
                        <th style="width:27mm;text-align: center;">Цена</th>
                        <th style="width:27mm;text-align: center;">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in form.invoice_items" :key="item.id">
                        <td style="text-align: center;">{{i+1}}</td>
                        <!--<td style="text-align: center;">{{item.product.item_code}}</td>
                        <td style="text-align: left;">{{item.product.item_name}}</td>-->
                        <td v-if="item.product">{{item.product.item_name}}</td>
                        <td v-else>{{item.item_name}}</td>

                        <td style="text-align: center;">{{item.quantity}}</td>
                        <td style="text-align: right;">{{item.price}},00</td>
                        <td style="text-align: right;">{{item.quantity * item.price}},00</td>
                    </tr>
                </tbody>
            </table>

            <table border="0" width="100%" cellpadding="1" cellspacing="1">
                <tr>
                    <td></td>
                    <td style="width:37mm; font-weight:bold;  text-align:right;">Итого:</td>
                    <td style="width:37mm; font-weight:bold;  text-align:right;">{{form.sub_total}},00</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:37mm; font-weight:bold;  text-align:right;">Без налога (НДС)</td>
                    <td style="width:37mm; font-weight:bold;  text-align:right;">-</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="width:37mm; font-weight:bold;  text-align:right;">Всего к оплате:</td>
                    <td style="width:37mm; font-weight:bold;  text-align:right;">{{form.total}},00</td>
                </tr>
            </table>

            <br />
            <div>
            Всего наименований 0 на сумму 0.00 рублей.<br />
            Ноль рублей 00 копеек</div>
            <br />
            <div style="background-color:#000000; width:100%; font-size:1px; height:2px;">&nbsp;</div>
            <br/>

            <div>Руководитель ____________________________________________ Довгалев М. М.</div>
            <br/>

            <div>Главный бухгалтер ____________________________________________ (Фамилия И.О.)</div>
            <br/>

            <div style="width: 85mm;text-align:center;">М.П.</div>
            <br/>


            <div style="width:700px;text-align:left;font-size:10pt;">Счет действителен к оплате в течении трех дней.</div>
        </div>
    </div>
</template>