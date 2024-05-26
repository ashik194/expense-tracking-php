<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="max-w-md w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-cover bg-center h-56 p-4" style="background-image: url('images/profile-background.jpg')">
            <div class="flex justify-end">
                <button class="text-white hover:text-gray-200 focus:outline-none focus:text-gray-300">
                    <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M18.364 4.636l-2.122-2.122L12 6.757 7.757 2.514 5.636 4.636 10.879 9.88l-5.243 5.243 2.121 2.122L12 12l4.243 4.243 2.121-2.122-5.243-5.243 5.243-5.243z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-4">
            <div class="text-center">
                <img class="h-24 w-24 rounded-full mx-auto -mt-16 border-4 border-white" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile picture">
                <h2 class="text-2xl font-semibold mt-2">John Doe</h2>
                <p class="text-gray-600">Web Developer</p>
            </div>
            <div class="mt-4">
                <h3 class="text-gray-700 font-semibold">About</h3>
                <p class="text-gray-600 text-sm mt-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed
                    vitae
                    risus nec mauris sollicitudin luctus.</p>
            </div>
            <div class="mt-4">
                <h3 class="text-gray-700 font-semibold">Skills</h3>
                <div class="flex flex-wrap mt-2">
                    <span class="m-1 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">JavaScript</span>
                    <span class="m-1 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">React</span>
                    <span class="m-1 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Node.js</span>
                    <span class="m-1 bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Tailwind CSS</span>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-gray-700 font-semibold">Social Media</h3>
                <div class="flex justify-center space-x-4 mt-2">
                    <a href="#" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 5.5 4.46 9.96 9.96 9.96 5.5 0 9.96-4.46 9.96-9.96 0-5.5-4.46-9.96-9.96-9.96zm0 1.8c2.23 0 2.48.01 3.36.05 1.16.05 1.75.24 2.17.41.5.2.86.45 1.24.83.38.38.63.74.83 1.24.18.42.36 1.01.41 2.17.04.88.05 1.13.05 3.36 0 2.23-.01 2.48-.05 3.36-.05 1.16-.24 1.75-.41 2.17-.2.5-.45.86-.83 1.24-.38.38-.74.63-1.24.83-.42.18-1.01.36-2.17.41-.88.04-1.13.05-3.36.05-2.23 0-2.48-.01-3.36-.05-1.16-.05-1.75-.24-2.17-.41-.5-.2-.86-.45-1.24-.83-.38-.38-.63-.74-.83-1.24-.18-.42-.36-1.01-.41-2.17-.04-.88-.05-1.13-.05-3.36 0-2.23.01-2.48.05-3.36.05-1.16.24-1.75.41-2.17.2-.5.45-.86.83-1.24.38-.38.74-.63 1.24-.83.42-.18 1.01-.36 2.17-.41.88-.04 1.13-.05 3.36-.05zm0 4.32a4.68 4.68 0 100 9.36 4.68 4.68 0 000-9.36zm0 1.8a2.88 2.88 0 110 5.76 2.88 2.88 0 010-5.76zm4.77-2.97a1.08 1.08 0 11-2.16 0 1.08 1.08 0 012.16 0z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2.04c-5.5 0-9.96 4.46-9.96 9.96 0 5.5 4.46 9.96 9.96 9.96 5.5 0 9.96-4.46 9.96-9.96 0-5.5-4.46-9.96-9.96-9.96zm4.4 9.15v.5c0 5.17-3.94 11.12-11.12 11.12-2.21 0-4.27-.65-6.01-1.77.3.03.61.05.92.05 1.84 0 3.52-.62 4.86-1.67-1.72-.03-3.17-1.17-3.67-2.73.24.04.49.06.74.06.36 0 .72-.05 1.06-.14-1.8-.36-3.15-1.96-3.15-3.88v-.05c.53.29 1.13.46 1.77.48-1.05-.7-1.75-1.91-1.75-3.27 0-.72.19-1.39.52-1.97 1.91 2.34 4.77 3.87 7.99 4.03-.07-.29-.1-.6-.1-.91 0-2.21 1.8-4.01 4.01-4.01 1.15 0 2.19.49 2.92 1.28.91-.18 1.77-.51 2.54-.97-.3.94-.94 1.73-1.77 2.23.81-.1 1.58-.31 2.3-.63-.54.8-1.21 1.5-2 2.06z" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M24 4.56v15.33c0 .74-.6 1.34-1.34 1.34H1.34A1.34 1.34 0 010 19.89V4.56c0-.74.6-1.34 1.34-1.34h21.33c.74 0 1.34.6 1.34 1.34zM8.09 19.53H5.18v-8.64h2.91v8.64zm-1.45-9.84a1.67 1.67 0 110-3.33 1.67 1.67 0 010 3.33zm11.18 9.84h-2.91v-4.63c0-1.1-.02-2.52-1.54-2.52-1.55 0-1.79 1.21-1.79 2.44v4.71h-2.91v-8.64h2.79v1.18h.04c.39-.74 1.35-1.53 2.78-1.53 2.97 0 3.51 1.96 3.51 4.5v5.49z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
