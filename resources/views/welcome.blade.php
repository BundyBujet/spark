<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Spark – Persoanl Space</title>

  <!-- Favicon (simple blue spark / lightning bolt) -->
  <link rel="icon" type="image/svg+xml" href="/assets/images/g-8.png" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'spark-darker': '#020617',
            'spark-dark':   '#0f172a',
            'spark-blue':   '#3b82f6',
            'spark-blue-dark': '#1d4ed8',
            'spark-blue-light': '#60a5fa',
          },
          animation: {
            'float': 'float 7s ease-in-out infinite',
            'fade-up': 'fadeUp 1.1s ease-out forwards',
            'pulse-slow': 'pulseSlow 9s cubic-bezier(0.4, 0, 0.6, 1) infinite',
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0)' },
              '50%':     { transform: 'translateY(-18px)' }
            },
            fadeUp: {
              '0%':   { opacity: '0', transform: 'translateY(40px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            },
            pulseSlow: {
              '0%, 100%': { opacity: '0.35' },
              '50%':      { opacity: '0.85' }
            }
          }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-spark-darker text-gray-100 min-h-screen font-sans antialiased overflow-x-hidden">

  <!-- Hero / Welcome You -->
  <section class="relative min-h-screen flex items-center justify-center px-5 sm:px-8 py-20">

    <!-- Subtle background glow -->
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute left-1/4 top-1/3 w-96 h-96 bg-spark-blue/8 rounded-full blur-3xl animate-pulse-slow"></div>
      <div class="absolute right-1/4 bottom-1/4 w-80 h-80 bg-spark-blue-dark/8 rounded-full blur-3xl animate-pulse-slow delay-2000"></div>
    </div>

    <div class="relative max-w-4xl mx-auto text-center z-10">

      <div class="inline-flex flex-col sm:flex-row items-center gap-5 sm:gap-6 mb-10 animate-fade-up">
        <div class="relative">
          <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-br from-spark-blue to-spark-blue-dark flex items-center justify-center shadow-2xl shadow-blue-800/40 animate-float">
            <img class="rounded-md" src="assets/images/g-8.png" alt="spark logo" />
          </div>
          <div class="absolute -inset-5 bg-spark-blue/15 rounded-3xl blur-2xl -z-10 animate-pulse-slow"></div>
        </div>

        <div class="text-left sm:text-center">
          <h1 class="text-6xl sm:text-7xl font-black tracking-tight bg-gradient-to-r from-white via-gray-200 to-spark-blue-light bg-clip-text text-transparent">
            Spark
          </h1>
          <p class="mt-2 text-xl sm:text-2xl text-gray-400 font-light">Personal's space</p>
        </div>
      </div>

      <p class="mt-8 text-2xl sm:text-3xl font-light text-gray-300 leading-relaxed animate-fade-up" style="animation-delay: 400ms;">
        Where I dump thoughts,<br class="sm:hidden">
        chase tasks,<br>
        and keep pieces of myself<br class="sm:hidden"> from disappearing.
      </p>

      <div class="mt-16 flex flex-col sm:flex-row items-center justify-center gap-6 animate-fade-up" style="animation-delay: 700ms;">
        <a href="/admin/login" 
           class="group relative px-12 py-6 rounded-2xl text-xl font-semibold overflow-hidden transition-all duration-400 shadow-xl shadow-blue-900/30 hover:shadow-blue-700/50">
          <div class="absolute inset-0 bg-gradient-to-r from-spark-blue to-spark-blue-dark scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500"></div>
          <span class="relative">Enter Spark →</span>
        </a>

        <a href="/admin/items?type=note" 
           class="px-10 py-5 rounded-xl text-lg font-medium text-spark-blue-light border border-spark-blue/30 hover:border-spark-blue/60 hover:bg-spark-blue/5 transition-all duration-300">
          Quick notes I wrote to myself
        </a>
      </div>

    </div>
  </section>

  <!-- Very personal mini section -->
  <section id="notes" class="py-24 sm:py-32 border-t border-slate-800/40 bg-spark-dark/20">
    <div class="max-w-4xl mx-auto px-6">

      <h2 class="text-3xl sm:text-4xl font-bold tracking-tight text-center mb-16 animate-fade-up">
        Reminders I keep telling myself
      </h2>

      <div class="grid sm:grid-cols-2 gap-8">

        <div class="bg-spark-dark/60 border border-slate-800/50 rounded-2xl p-8 hover:border-spark-blue/30 transition-colors duration-400">
          <p class="text-xl leading-relaxed text-gray-200">
            Stop waiting for perfect mood.<br>
            <span class="text-spark-blue-light font-medium">Start with 5 stupid minutes.</span>
          </p>
          <p class="mt-6 text-sm text-gray-500">— written at 3 AM too many times</p>
        </div>

        <div class="bg-spark-dark/60 border border-slate-800/50 rounded-2xl p-8 hover:border-spark-blue/30 transition-colors duration-400">
          <p class="text-xl leading-relaxed text-gray-200">
            Capture everything.<br>
            <span class="text-spark-blue-light font-medium">Future ME will thank me.</span>
          </p>
          <p class="mt-6 text-sm text-gray-500">— why this whole thing exists</p>
        </div>

      </div>

      <div class="mt-16 text-center">
        <a href="/admin" 
           class="inline-block px-10 py-5 text-lg font-medium rounded-xl bg-spark-blue/10 hover:bg-spark-blue/20 text-spark-blue-light border border-spark-blue/20 hover:border-spark-blue/40 transition-all duration-300">
          ← Back to dashboard
        </a>
      </div>

    </div>
  </section>

  <!-- Tiny footer -->
  <footer class="py-12 text-center text-gray-600 text-sm border-t border-slate-800/40">
    <p>Just me • B.B • {{date("Y")}}</p>
  </footer>

</body>
</html>
