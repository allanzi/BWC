<template>
    <div>
        <a href="#create-modal" class="btn btn-floating blue-grey darken-4 waves-effect modal-trigger"><i
                class="material-icons">add</i></a>
        <div id="create-modal" class="modal">
            <form method="post" @submit.prevent="onSubmit">
                <div class="modal-content">
                    <h4>Novo Veículo</h4>
                    <div class="row">

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input v-model="name" name="Nome" id="name" type="text"
                                           v-validate="'required|max:255'"/>
                                    <label for="name">Veículo</label>
                                    <span class="red-text">{{ errors.first('Nome') }}</span>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input v-model="brand" name="Marca" id="brand" type="text"
                                           v-validate="'required|max:255'"/>
                                    <label for="brand">Marca</label>
                                    <span class="red-text">{{ errors.first('Marca') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input v-model="year" name="Ano" id="year" type="number"
                                           v-validate="'required|integer|min_value:1900'"/>
                                    <label for="year">Ano</label>
                                    <span class="red-text">{{ errors.first('Ano') }}</span>
                                </div>

                                <div class="col m6 s12">
                                    <br>
                                    <div class="switch">
                                        <label>
                                            À Venda
                                            <input type="checkbox" v-model="has_sold" name="Vendido?">
                                            <span class="lever"></span>
                                            Vendido
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-field col s12">
                            <textarea v-model="description" name="Descricao" id="description"
                                      class="materialize-textarea" v-validate="'required'"
                                      data-vv-as="Descrição"></textarea>
                            <label for="description">Descrição</label>
                            <span class="red-text">{{ errors.first('Descricao') }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="waves-effect waves-green btn-flat blue-grey darken-4 white-text">Add
                    </button>
                    <a href="javascript:void(0)"
                       class="modal-close waves-effect waves-green btn-flat blue-grey darken-4 white-text">Fechar</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                brand: '',
                year: '',
                has_sold: '',
                description: ''
            }
        },
        created() {

        },
        methods: {
            onSubmit() {
                const url = `${window.laravel.url}/api/vehicles/`;
                const data = {
                    'name': this.name,
                    'brand': this.brand,
                    'year': this.year,
                    'has_sold': $("input[type='checkbox']").prop('checked'),
                    'description': this.description
                };

                this.$validator.validateAll().then((result) => {
                    if ( result ) {
                        Materialize.toast('Criando veículo...');

                        window.axios.post(url, data)
                            .then((response) => {

                                $('.modal').modal('close');

                                Materialize.Toast.removeAll();
                                Materialize.toast('Veículos criado com sucesso :D', 3500);
                                EventBus.$emit('createdVehicle', response.data.data);
                            });

                        return;
                    }

                    Materialize.toast('Corriga os erros do formulário e tente novamente!');
                });
            }
        }
    }
</script>

<style scoped>

</style>