<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Por</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Nahuel Diaz</a> </div>

    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
            <img alt="Avatar" src="{{ asset('dist/images/profile-2.jpg')}}">
        </div>
        <div class="dropdown-menu w-56">
            <div class="dropdown-menu__content box bg-theme-26 dark:bg-dark-6 text-white">
                <div class="p-4 border-b border-theme-27 dark:border-dark-3">
                    {{-- Nombre de usuario Logeado--}}
                    <div class="font-medium">{{ Auth()->user()->nombre}}</div>
                    <div class="text-xs text-theme-28 mt-0.5 dark:text-gray-600">Developer</div>
                </div>
                <div class="p-2">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="user" class="w-4 h-4 mr-2"></i> Perfil </a>

                </div>
                <div class="p-2 border-t border-theme-27 dark:border-dark-3">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Salir </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>
