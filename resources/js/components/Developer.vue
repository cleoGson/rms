<template>
<section class="content">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard Component</div>

                    <div class="card-body">

                    <passport-clients></passport-clients>
                    <passport-authorized-clients></passport-authorized-clients>
                    <passport-personal-access-tokens></passport-personal-access-tokens>
                    
                    </div>
                </div>
            </div>
    </div>
    </section>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
