<template>
    <div>
        <br>
        <div class="col s6">
            <p>Lista de veículos</p>
            <div class="card-container">
                <div class="card horizontal pointer" v-for="vehicle in vehicles"
                     v-on:click="updateDetails(vehicle.id)"
                     v-bind:class="[vehicle.id == details.id ? 'blue-grey darken-1 white-text' : '']">
                    <div class="card-stacked">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s10">
                                    <p class="text-upper"
                                       v-bind:class="[vehicle.id == details.id ? 'white-text' : 'black-text']">
                                        {{vehicle.brand}}</p>
                                    <p v-bind:class="[vehicle.id == details.id ? 'light-green-text lighten-5' : 'teal-text lighten-2']">
                                        {{vehicle.name}}</p>
                                    <p class="grey-text lighten-1">{{vehicle.year}}</p>
                                </div>

                                <div class="col s2">
                                    <i class="material-icons marker">local_offer</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s6">
            <p>Detalhes</p>
            <div class="card horizontal grey lighten-4">
                <div class="card-stacked">
                    <div class="card-content card-container-details">
                        <div class="row">
                            <div class="col s12">
                                <p class="teal-text lighten-2 flow-text">{{details.name}}</p>

                                <br/>

                                <div class="row">
                                    <div class="col s6">
                                        <P>Marca</P>
                                        <p class="text-upper grey-text lighten-1">{{details.brand}}</p>
                                    </div>

                                    <div class="col s6">
                                        <P>Ano</P>
                                        <p class="grey-text lighten-1">{{details.year}}</p>
                                    </div>
                                </div>

                                <p>
                                    {{details.description}}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-action lighten-2">
                        <a href="#update-modal" class="btn blue-grey darken-4 modal-trigger"><i
                                class="material-icons left">edit</i> Editar</a>

                        <i class="material-icons right marker-details">local_offer</i>
                    </div>
                </div>
            </div>
        </div>

        <div id="update-modal" class="modal">
            <form method="post" @submit.prevent="onSubmit">
                <div class="modal-content">
                    <h4>Atualizar Veículo: {{details.name}}</h4>
                    <div class="row">

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input v-model="details.name" name="Nome" id="name" type="text"
                                           v-validate="'required|max:255'"/>
                                    <label for="name">Veículo</label>
                                    <span class="red-text">{{ errors.first('Nome') }}</span>
                                </div>

                                <div class="input-field col m6 s12">
                                    <input v-model="details.brand" name="Marca" id="brand" type="text"
                                           v-validate="'required|max:255'"/>
                                    <label for="brand">Marca</label>
                                    <span class="red-text">{{ errors.first('Marca') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col s12">
                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input v-model="details.year" name="Ano" id="year" type="number"
                                           v-validate="'required|integer|min_value:1900'"/>
                                    <label for="year">Ano</label>
                                    <span class="red-text">{{ errors.first('Ano') }}</span>
                                </div>

                                <div class="col m6 s12">
                                    <br>
                                    <div class="switch">
                                        <label>
                                            À Venda
                                            <input type="checkbox" v-model="details.has_sold" name="Vendido?">
                                            <span class="lever"></span>
                                            Vendido
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-field col s12">
                            <textarea v-model="details.description" name="Descricao" id="description"
                                      class="materialize-textarea" v-validate="'required'"
                                      data-vv-as="Descrição"></textarea>
                            <label for="description">Descrição</label>
                            <span class="red-text">{{ errors.first('Descricao') }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="waves-effect waves-green btn-flat blue-grey darken-4 white-text">
                        Atualizar
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
                vehicles: [],
                details: {
                    id: '',
                    name: '',
                    brand: '',
                    year: '',
                    description: '',
                    has_sold: ''
                }
            }
        },
        mounted() {
            const windowHeight = $(window).height();
            if ( windowHeight > 425 ) {
                $('.card-container').css('height', (windowHeight - (windowHeight * 0.3136)));
                $('.card-container-details').css('height', (windowHeight - (windowHeight * 0.415)));
            }
        },
        created() {
            this.getAll();

            EventBus.$on('createdVehicle', (dataPassed) => this.vehicles = dataPassed);
        },
        methods: {
            updateDetails(id) {
                const url = `${window.laravel.url}/api/vehicles/${id}`;
                window.axios.get(url).then((response) => {
                    this.details = response.data.data;
                });
            },
            getAll() {
                const search = location.search.substring(3);
                const url = search == '' ? `${window.laravel.url}/api/vehicles` : `${window.laravel.url}/api/vehicles/find?q=${search}`;
                window.axios.get(url).then((response) => {
                    this.vehicles = response.data.data;
                    this.details = response.data.data[0];
                });
            },
            clickedUpdateModal(details) {
                EventBus.$emit('clickedUpdateModal', this.details);
            },
            onSubmit() {
                const url = `${window.laravel.url}/api/vehicles/${this.details.id}`;
                const checked = $("input[type='checkbox']").prop('checked') ? '0' : '1';
                const data = `?name=${this.details.name}&brand=${this.details.brand}&year=${this.details.year}&has_sold=${checked}&description=${this.details.description}`;

                this.$validator.validateAll().then((result) => {
                    if ( result ) {
                        Materialize.toast('Atualizando veículo...');

                        window.axios.put(url + data)
                            .then((response) => {

                                EventBus.$emit('customEvent', 'a text to pass');

                                $('.modal').modal('close');

                                Materialize.Toast.removeAll();
                                Materialize.toast('Veículos atualizado com sucesso :D', 3500);
                                this.getAll()
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
    .marker {
        -webkit-transform: translateY(95%);
        -moz-transform: translateY(95%);
        -ms-transform: translateY(95%);
        -o-transform: translateY(95%);
        transform: translateY(95%);
    }

    .marker-details {
        -webkit-transform: translateY(30%);
        -moz-transform: translateY(30%);
        -ms-transform: translateY(30%);
        -o-transform: translateY(30%);
        transform: translateY(30%);
    }

    .card-container, .card-container-details {
        overflow-y: scroll;
    }

    .card-container .card .card-content {
        padding: 10px 24px;
    }

    .card-container .card .card-content .row {
        margin-bottom: 0;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active em versões anteriores a 2.1.8 */
    {
        opacity: 0;
    }
</style>