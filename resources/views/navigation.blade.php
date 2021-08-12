<h3 :to="{name: 'nova-page-manager-tool'}" class="flex items-center font-normal text-white mb-6 text-base no-underline">
    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
    </svg>

    <span class="sidebar-label">
        {{ __('Page Manager') }}
    </span>
</h3>


<ul class="list-reset mb-8">
    <li class="leading-wide mb-4 text-sm">
        <router-link :to="{
        name: 'index',
        params: {
            resourceName: 'pages'
        }
        }" class="text-white ml-8 no-underline dim">
            {{ __('Pages') }}
        </router-link>
    </li>

</ul>

