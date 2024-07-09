<div class="fixed bottom-4 right-0 z-50 mx-4 w-[calc(100%_-_32px)] sm:w-auto">
    <div class="w-full">
        <div
            class="formbold-form-wrapper mx-auto {{ $errors->any() ? '' : 'hidden' }} w-full lg:w-[326px] rounded-lg border border-[#e0e0e0] bg-white">
            {{-- class="formbold-form-wrapper mx-auto hidden w-full max-w-[550px] rounded-lg border border-[#e0e0e0] bg-white"> --}}
            <div class="flex items-center justify-between rounded-t-lg bg-primary p-4">
                <h3 class="text-xl font-bold text-white">{{ __('system.feedback.feedback') }}</h3>
                <button onclick="chatboxToogleHandler()" class="text-white">
                    <svg width="17" height="17" viewBox="0 0 17 17" class="fill-current">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.474874 0.474874C1.10804 -0.158291 2.1346 -0.158291 2.76777 0.474874L16.5251 14.2322C17.1583 14.8654 17.1583 15.892 16.5251 16.5251C15.892 17.1583 14.8654 17.1583 14.2322 16.5251L0.474874 2.76777C-0.158291 2.1346 -0.158291 1.10804 0.474874 0.474874Z" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.474874 16.5251C-0.158291 15.892 -0.158291 14.8654 0.474874 14.2322L14.2322 0.474874C14.8654 -0.158292 15.892 -0.158291 16.5251 0.474874C17.1583 1.10804 17.1583 2.1346 16.5251 2.76777L2.76777 16.5251C2.1346 17.1583 1.10804 17.1583 0.474874 16.5251Z" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('feedbacks.store') }}" method="POST" class="p-4" id="feedback-form">
                @csrf
                <input type="hidden" value="{{ $restaurant->id }}" name="restaurant_id">
                <div class="mb-3">
                    <label for="name" class="block font-medium text-sm mb-1">
                        {{ __('system.feedback.your_name') }}
                    </label>
                    <input autocomplete="off" type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="{{ __('system.feedback.enter_your_name') }}" required
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-4 text-base outline-none focus:border-primary focus:shadow-md"
                        data-rule-required="true" placeholder="{{ __('system.fields.name') }}"
                        data-msg-required="{{ __('validation.required', ['attribute' => __('system.contact_us.name')]) }}"
                        data-rule-minlength="3"
                        data-msg-minlength="{{ __('validation.min.numeric', ['attribute' => __('system.fields.name'), 'min' => 3]) }}" />
                    @error('name')
                        <em class="text-[red] w-full text-xs error-back">
                            *{{ $message }}
                        </em>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="block font-medium text-sm mb-1">
                        {{ __('auth.email') }}
                    </label>
                    <input autocomplete="off" type="email" name="email" id="email" value="{{ old('email') }}"
                        placeholder="{{ __('system.feedback.enter_your_email') }}" required
                        data-msg-required="{{ __('validation.required', ['attribute' => __('auth.email')]) }}"
                        data-rule-required="true" data-rule-email="true"
                        data-msg-email="{{ __('validation.email', ['attribute' => __('auth.email')]) }}"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-4 text-base outline-none focus:border-primary focus:shadow-md" />
                    @error('email')
                        <em class="text-[red] w-full text-xs error-back">
                            *{{ $message }}
                        </em>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="message" class="block font-medium text-sm mb-1">
                        {{ __('system.feedback.message') }}
                    </label>
                    <textarea rows="4" name="message" required id="message" placeholder="{{ __('system.feedback.message') }}"
                        data-msg-required="{{ __('validation.required', ['attribute' => __('system.contact_us.message')]) }}"
                        data-rule-required="true" data-rule-minlength="5"
                        data-msg-minlength="{{ __('validation.min.numeric', ['attribute' => __('system.contact_us.message'), 'min' => 5]) }}"
                        class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-4 text-base outline-none focus:border-primary focus:shadow-md">{{ old('message') }}</textarea>
                    @error('message')
                        <em class="text-[red] w-full text-xs error-back">
                            *{{ $message }}
                        </em>
                    @enderror
                </div>
                <div>
                    <button type="submit"
                        class="hover:shadow-form w-full rounded-md bg-primary py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        {{ __('system.feedback.send_feedback') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="mx-auto mt-4 flex max-w-[550px] items-center justify-end space-x-5">
            <button class="flex h-14 w-14 items-center justify-center rounded-full bg-primary text-white"
                onclick="chatboxToogleHandler()">
                <span class="cross-icon {{ $errors->any() ? '' : 'hidden' }}">
                    <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.474874 0.474874C1.10804 -0.158291 2.1346 -0.158291 2.76777 0.474874L16.5251 14.2322C17.1583 14.8654 17.1583 15.892 16.5251 16.5251C15.892 17.1583 14.8654 17.1583 14.2322 16.5251L0.474874 2.76777C-0.158291 2.1346 -0.158291 1.10804 0.474874 0.474874Z"
                            fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.474874 16.5251C-0.158291 15.892 -0.158291 14.8654 0.474874 14.2322L14.2322 0.474874C14.8654 -0.158292 15.892 -0.158291 16.5251 0.474874C17.1583 1.10804 17.1583 2.1346 16.5251 2.76777L2.76777 16.5251C2.1346 17.1583 1.10804 17.1583 0.474874 16.5251Z"
                            fill="white" />
                    </svg>
                </span>
                <span class="chat-icon {{ $errors->any() ? 'hidden' : '' }}">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.8333 14.0002V3.50016C19.8333 3.19074 19.7103 2.894 19.4915 2.6752C19.2728 2.45641 18.976 2.3335 18.6666 2.3335H3.49992C3.1905 2.3335 2.89375 2.45641 2.67496 2.6752C2.45617 2.894 2.33325 3.19074 2.33325 3.50016V19.8335L6.99992 15.1668H18.6666C18.976 15.1668 19.2728 15.0439 19.4915 14.8251C19.7103 14.6063 19.8333 14.3096 19.8333 14.0002ZM24.4999 7.00016H22.1666V17.5002H6.99992V19.8335C6.99992 20.1429 7.12284 20.4397 7.34163 20.6585C7.56042 20.8772 7.85717 21.0002 8.16659 21.0002H20.9999L25.6666 25.6668V8.16683C25.6666 7.85741 25.5437 7.56066 25.3249 7.34187C25.1061 7.12308 24.8093 7.00016 24.4999 7.00016Z"
                            fill="white" />
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
<script>
    const formWrapper = document.querySelector(".formbold-form-wrapper");
    const crossIcon = document.querySelector(".cross-icon");
    const chatIcon = document.querySelector(".chat-icon");

    function chatboxToogleHandler() {
        clearForm(document.getElementById("feedback-form"));
        formWrapper.classList.toggle("hidden");
        crossIcon.classList.toggle("hidden");
        chatIcon.classList.toggle("hidden");
    }

    $('#feedback-form').validate({
        errorPlacement: function(error, element) {
            error.appendTo(element.parent()).addClass('text-[red]');
        },
        highlight: function(element) {
            $(element).addClass("error");
        },
        unhighlight: function(element) {
            $(element).removeClass("error");
        }
    });

    function clearForm(myFormElement) {

        const elements = myFormElement.elements;

        const errors = document.getElementsByClassName("error-back");
        for (error of errors) {
            error.remove();
        }

        myFormElement.reset();

        for (i = 0; i < elements.length; i++) {

            field_type = elements[i].type.toLowerCase();

            switch (field_type) {

                case "text":
                case "password":
                case "textarea":
                case "email":

                    elements[i].value = "";
                    break;

                case "radio":
                case "checkbox":
                    if (elements[i].checked) {
                        elements[i].checked = false;
                    }
                    break;

                case "select-one":
                case "select-multi":
                    elements[i].selectedIndex = -1;
                    break;

                default:
                    break;
            }
        }
    }
</script>
