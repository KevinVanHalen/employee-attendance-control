<template>
    <v-card hover color="#DADDDD" height="300" width="300">
        <div class="d-flex flex-column align-items-center">
            <v-icon style="font-size: 130px" class="mt-10" large color="#013154">{{icon}}</v-icon>
            <div class="col-auto my-text boton-principal-top">{{text}}</div>
        </div>
    </v-card>
</template>

<script>
export default {
    name: 'boton-principal',
    props: {
        text: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        }
    }
}
</script>