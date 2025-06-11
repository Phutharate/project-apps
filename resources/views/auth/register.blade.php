<x-guest-layout>
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden md:max-w-2xl p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">สมัครสมาชิก</h2>
            <p class="text-gray-600 mt-2">กรุณากรอกข้อมูลเพื่อสร้างบัญชีใหม่</p>
        </div>
        <style>
/* ซ่อนลูกศรของ select เฉพาะใน Chrome, Safari, Edge */
select::-webkit-appearance {
  -webkit-appearance: none;
  appearance: none;
}

/* สำหรับ Firefox */
select:-moz-focusring {
  color: transparent;
  text-shadow: 0 0 0 #000;
}

/* ถ้าต้องการให้ไอคอนไม่แสดงเลย */
select {
  background-image: none !important;
}
</style>

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <x-text-input id="name"
                        class="block w-full pl-10 py-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        placeholder="ชื่อของคุณ" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Position -->
            <div>
                <x-input-label for="position" :value="__('ตำแหน่ง')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <x-text-input id="position" name="position" type="text"
                        class="block w-full pl-3 py-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="เช่น นักวิชาการคอมพิวเตอร์" value="{{ old('position') }}" required />
                </div>
                <x-input-error :messages="$errors->get('position')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Department -->
            <div>
                <x-input-label for="department" :value="__('กลุ่ม/ฝ่าย')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <x-text-input id="department" name="department" type="text"
                        class="block w-full pl-3 py-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="เช่น กลุ่มงานเทคโนโลยีสารสนเทศ" value="{{ old('department') }}" required />
                </div>
                <x-input-error :messages="$errors->get('department')" class="mt-2 text-sm text-red-600" />
            </div>


            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <x-text-input id="email"
                        class="block w-full pl-10 py-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        type="email" name="email" :value="old('email')" required autocomplete="username"
                        placeholder="your@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">บทบาท</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <select name="role" id="role" required
                        class="mt-1 block w-full pl-10 py-3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="user">user</option>
                    </select>
                </div>
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <x-text-input id="password"
                        class="block w-full pl-10 py-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                    class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <x-text-input id="password_confirmation"
                        class="block w-full pl-10 py-3 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                        type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button
                    class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
