<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoes SCM - Login Sistem Rantai Pasok</title>

    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full flex items-center justify-center p-4 antialiased text-gray-800 bg-gradient-to-br from-slate-100 via-indigo-50/30 to-slate-100">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" 
         x-data="{ showPassword: false, loading: false }">
        
        <!-- Header Branding -->
        <div class="bg-orange-600 px-8 py-8 text-white text-center relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-orange-600/30 rounded-full blur-xl"></div>
            <div class="inline-flex p-3 bg-white/10 rounded-2xl backdrop-blur-md mb-3">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-black tracking-tight">Shoes SCM Portal</h1>
            <p class="text-xs text-indigo-200 mt-1">Masuk untuk mengelola inventaris & rantai pasok</p>
        </div>

        <div class="p-8 space-y-6">

            <!-- Flash Alert Errors / Success -->
            @if(session('success'))
                <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold rounded-xl flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold rounded-xl flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.post') }}" @submit="loading = true" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email Akses</label>
                    <div class="relative">
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="admin@shoesscm.com" 
                               class="w-full pl-10 pr-4 py-2.5 text-sm border @error('email') border-rose-400 bg-rose-50/30 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                    @error('email')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                               placeholder="••••••••" 
                               class="w-full pl-10 pr-10 py-2.5 text-sm border @error('password') border-rose-400 bg-rose-50/30 @else border-gray-300 @enderror rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        
                        <!-- Toggle Visible Password -->
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.025 10.025 0 012.122-.063c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-3.5-3.5a3 3 0 00-4.243-4.243"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-rose-600 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        :disabled="loading"
                        class="w-full py-3 bg-orange-500 hover:bg-orange-700 text-white font-bold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98 disabled:opacity-70">
                    <span x-show="!loading">Masuk ke Dashboard</span>
                    <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                        <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </form>

            <!-- Demo Credential Info Badge -->
            <div class="bg-indigo-50/60 rounded-xl p-3 text-xs text-orange-600 border border-indigo-100">
                <p class="font-bold mb-1">Akun Demo Testing:</p>
                <p>Email: <code class="bg-indigo-100 px-1 py-0.5 rounded text-orange-600 font-mono">admin@shoesscm.com</code></p>
                <p>Password: <code class="bg-indigo-100 px-1 py-0.5 rounded text-orange-600 font-mono">password123</code></p>
            </div>

        </div>
    </div>

</body>
</html>