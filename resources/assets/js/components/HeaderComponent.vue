<template>
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper container">
                <a href="/" class="brand-logo">
                    <img src="/imgs/logo.png" alt="Logo image" class="responsive-img"/>
                    <span>FULLSTACK</span>
                </a>

                <form class="right hide-on-small-only" method="get">
                    <div class="input-field white-text">
                        <input id="searchNavBar" type="search" name="q" placeholder="BUSCA por um veículo" v-bind:value="[search]" ref="search" required />
                        <i class="material-icons">close</i>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: ''
            }
        },
        mounted() {
            this.search = location.search.substring(3);

            if ( this.search !== '' ) {
                this.$refs.search.focus()
            }
        }
    }
</script>

<style scoped>
    /*Alinha imagem do logo e nome*/
    div.nav-wrapper img {
        width: 49px;
        transform: translateY(5px);
        margin-right: 10px;
    }

    a.brand-logo span{
        position: relative;
        top: -7px;
    }
    
    @media (max-width: 425px) {
        div.nav-wrapper img {
            width: 46px;
        }

        a.brand-logo{
            width: 225px;
        }

        a.brand-logo span{
            top: -6px;
        }
    }
    /*/Alinha imagem do logo e nome*/

    #searchNavBar {
        width: 100%;
    }

    #searchNavBar + i {
        right: 0;
    }
</style>