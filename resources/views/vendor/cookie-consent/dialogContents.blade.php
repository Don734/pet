
<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2 z-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-lime-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-full sm:w-auto">
                    <p class="text-black cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 sm:mt-0 sm:w-auto">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-black bg-lime-600 hover:bg-lime-700 hover:transition-all hover:duration-500">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

