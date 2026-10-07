<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HomeHero from '@/Components/HomeHero.vue';
import AssuranceBar from '@/Components/AssuranceBar.vue';
import PartnerTicker from '@/Components/PartnerTicker.vue';
import HardwareSelector from '@/Components/HardwareSelector.vue';
import ServicesSection from '@/Components/ServicesSection.vue';
import QuoteEstimator from '@/Components/QuoteEstimator.vue';
import TestimonialsSection from '@/Components/TestimonialsSection.vue';

defineProps({
  hardwareCategories: {
    type: Array,
    default: () => []
  },
  services: {
    type: Array,
    default: () => []
  }
});
</script>

<template>
  <Head title="Enterprise ICT Infrastructure & Hardware Supply - DTL" />

  <PublicLayout>
    <!-- Soft Crossfade Hero -->
    <HomeHero />

    <!-- Assurance Bar -->
    <AssuranceBar />

    <!-- Partner Logos Ticker -->
    <PartnerTicker />

    <!-- Interactive Solutions & Hardware Matrix -->
    <HardwareSelector :hardwareCategories="hardwareCategories" />

    <!-- 5. ICT & Infrastructure Services Matrix -->
    <ServicesSection :services="services" />

    <TestimonialsSection />

    <!-- 6. Interactive Lead / RFP Estimator -->
    <QuoteEstimator />
  </PublicLayout>
</template>