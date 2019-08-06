<template>
    <ol class="breadcrumb">
        <li><router-link :to="{ name:'home' }" ><i class="fa fa-dashboard"> Home</i> </router-link></li>
        <li class="active">{{ $route.meta.title }}</li>
    </ol>
</template>
<script>
export default {

}
</script>
