<x-layout title="Destrosolutions - Contact">
    <x-navbar variant="complex" prefix="page" hideNavLogo="true"/>
    <x-banner-page 
        :title="__('Contact us')" 
        :description="__('Get in touch for consultations, partnerships, and opportunities.')"
        imagePath="images/contact.jpeg"/>

    <main class="bg-white">
        <x-contact/>
    </main>
</x-layout>


