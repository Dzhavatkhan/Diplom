<template>
    <div class="wrapper w-full h-screen flex justify-center bg-[#F2F1F1] items-center">
        <div class="form-group">
            <div class="title">Регистрация</div>
            <strong>ReCaptcha:</strong>
            <div class="g-recaptcha" data-sitekey="6LfjeYQpAAAAAAbBO6IOk4iEZcqKjgCR6mMuQ092"></div>
            <!-- @if ($errors->has('g-recaptcha-response'))
                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
            @endif -->
        </div>
    </div>

</template>

<script setup>
import { onMounted, ref } from "vue";
let captcha =ref([])

const getCaptcha = async() => {
    let resposne = await axios.get("api/getCaptcha")
    captcha.value = resposne.data.sitekey
    console.log(captcha.value);
}
onMounted(async() =>{
    await getCaptcha()
})



</script>

<style scoped>

</style>
