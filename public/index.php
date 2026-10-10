<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>nextEra clothing- Style your Era..</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<style>
    .ul {
        display: grid;
        grid-template-columns: repeat(9, 1fr);
        transform-origin: top right;
        transform: skewY(0deg);
        margin: 0 6.4vw 0 28%;
    }

    .li {
        transform-origin: bottom left;
        transform: skewY(4.398705355deg) rotatez(14.03624deg);
        padding-top: 150%;
        z-index: 1;
        transition-property: z-index;
        transition-duration: 0.3s;
    }

    .details {
        position: absolute;
        z-index: 2;
        width: 100%;
        height: 100%;
        top: 0;
        background-color: #dadddf;
        border-radius: 2vw;
        box-shadow: inset 0px 0px 0px 7vw #fcf8f4;
        box-sizing: border-box;
        filter: drop-shadow(2px 6px 3px rgba(0, 0, 0, 0.4));
        transform: rotate(0deg) translate(0, 0);
        transition-property: transform;
        transition-duration: 0.3s;
    }

    .liimg {
        position: absolute;
        z-index: 4;
    }

    .liimg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 25px;
        padding: 5px;
    }

    .li:hover {
        z-index: 4;
    }

    .li:hover h2 {
        top: 80%;
    }

    .li:hover .details {
        transform: rotate(-14.03624deg) translate(5.5%, 15%) scale(1.5);
    }

    /* Cursor */
    .cursor {
        position: relative;
        width: 15em;
        margin: 0 auto;
        border-right: 4px solid rgb(0, 0, 0);
        font-size: 30px;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        transform: translateY(-50%);
    }

    /* Animation */
    .typewriter-animation {
        animation: typewriter 5s steps(50) 1s infinite,
            blinkingCursor 500ms steps(50) infinite normal;
    }

    #mockup1 {
        perspective: 1000px;
        /* 3D depth */
        transform-style: preserve-3d;
        position: relative;
    }

    #mockup1 img {
        transition: transform 0.5s ease, filter 0.5s ease;
        animation: infiniteTilt 6s linear infinite;
        filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.4));
        /* T-shirt shaped shadow */
    }

    @keyframes infiniteTilt {
        0% {
            transform: rotateX(10deg) rotateY(10deg) scale(1.05);
        }

        25% {
            transform: rotateX(-10deg) rotateY(15deg) scale(1.05);
        }

        50% {
            transform: rotateX(15deg) rotateY(-15deg) scale(1.05);
        }

        75% {
            transform: rotateX(-15deg) rotateY(-10deg) scale(1.05);
        }

        100% {
            transform: rotateX(10deg) rotateY(10deg) scale(1.05);
        }
    }

    #mockup1 {
        background: linear-gradient(132deg,
                #000000,
                #00ff00,
                #0000ff,
                #e60073,
                #ff0000,
                #ffffff,
                #ffcc00,
                #00ffff,
                #ff00ff,
                #6600cc,
                #ff9900);
        background-size: 800% 800%;
        animation: BackgroundGradient 8s linear infinite;
    }

    @keyframes BackgroundGradient {
        0% {
            background-position: 0% 50%;
        }

        100% {
            background-position: 100% 50%;
        }
    }

    @keyframes typewriter {
        from {
            width: 0;
        }

        to {
            width: 15em;
        }
    }

    @keyframes blinkingCursor {
        from {
            border-right-color: rgb(0, 0, 0);
        }

        to {
            border-right-color: transparent;
        }
    }

    /* Upscale animation */
    @keyframes upscale {
        0% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 1;
            transform: scale(1.1);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Downscale animation */
    @keyframes downscale {
        0% {
            opacity: 0;
            transform: scale(1);
        }

        50% {
            opacity: 1;
            transform: scale(1.1);
        }

        100% {
            opacity: 0;
            transform: scale(1);
        }
    }

    /* Apply animations */
    .animate-upscale {
        animation: upscale 4s infinite;
    }

    .animate-downscale {
        animation: downscale 4s infinite;
    }
</style>

<body class="bg-gradient-to-br from-fuchsia-500/50 via-violet-600/20 to-blue-700/50 ">
    <nav class="px-2 pt-2 lg:flex justify-between items-center bg-transparent">
        <h1 class="text-4xl px-2 text-black font-bold font-mono max-lg:text-center">nextEra</h1>
        <div
            class="cursor typewriter-animation text-2xl mt-6 font-mono font-bold bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 bg-clip-text text-transparent max-lg:text-center ">
            creating your nextEra...
        </div>
        <div class="space-x-4 mr-4 max-lg:mt-4 max-lg:flex max-lg:justify-center">
            <button onclick="window.location.href='login/login.php'"
                class="hover:scale-110 transition-transform duration-400 border-2 rounded-full px-4 py-1 opacity-100 shadow-[0px_0px_6px_2px_#f230e2] text-xl normal-case font-medium bg-gradient-to-bl from-stone-200 to-red-200 text-violet-600 hover:bg-yellow-500">
                Login
            </button>
            <button onclick="window.location.href='dashboard.php'"
                class="hover:scale-110 transition-transform duration-400 border-2 rounded-full px-4 py-1 opacity-100 shadow-[0px_0px_6px_2px_#f230e2] text-xl normal-case font-medium bg-gradient-to-bl from-stone-200 to-red-200 text-violet-600">
                Get Started →
            </button>
        </div>
    </nav>

    <h2 class="text-xl text-center font-serif pb-2 max-lg:pt-4">
        Style your Era &nbsp;<a href="./login/login.php" class="underline text-blue-600">login now...</a>
    </h2>

    <section class="mx-6 flex justify-between max-lg:flex-col">
        <div
            class="p-4 mx-auto lg:p-6 mt-10 h-fit lg:w-[28%] w-[98%] rounded-lg shadow-lg bg-gradient-to-br from-fuchsia-500/40 to-blue-500/40 hover:scale-105 transition-transform duration-500">
            <h1
                class="text-2xl font-bold text-center bg-gradient-to-r from-fuchsia-700 via-violet-600 to-blue-500 bg-clip-text text-transparent">
                Customize Your Tees <br />
                "Wear Your Imagination"
            </h1>
            <p class="text-lg my-4 text-gray-800 leading-relaxed">
                Why wear ordinary when you can
                <strong>create your own style ?</strong> Add your design, quote, or
                graphic and make a tee that's uniquely yours.
                <strong>Express yourself</strong> with every thread!
            </p>
            <button onclick="window.location.href='dashboard.php'"
                class="bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-4 py-2 rounded-md hover:scale-105 transition-transform duration-500">
                Get Started →
            </button>
        </div>

        <div id="mockup1"
            class="rounded-full shadow-[inset_0px_0px_100px_20px_rgba(217,_70,_239)] w-[20rem] h-[20rem] lg:w-[28rem] lg:h-[28rem] mx-auto flex justify-center items-center perspective-1000 overflow-hidden flex-col">
            <img src="landing_src/mockup1.png" alt=""
                class="w-[80%] h-[80%] mx-auto transition-transform duration-500 transform-gpu max-lg:w-[50%] max-lg:h-[50%]" />
            <button
                class="bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-8 py-2 rounded-md font-bold transition-transform duration-500 cursor-default">
                Shop Now
            </button>
        </div>

        <div
            class="p-4 lg:p-8 mx-auto w-[98%] lg:w-[28%] h-fit rounded-lg shadow-lg bg-gradient-to-br from-fuchsia-500/40 to-blue-500/40 hover:scale-105 transition-transform duration-500">
            <h1
                class="text-2xl  font-bold text-center bg-gradient-to-r from-fuchsia-700 via-violet-600 to-blue-500 bg-clip-text text-transparent">
                Trending Fashion <br />
                " Redefine Your Style "
            </h1>
            <p class="text-lg my-4 text-gray-800 leading-relaxed">
                Stay stylish with <strong>trending fashion</strong>. Whether it's bold
                streetwear or chic classics, <strong>dress to impress</strong> with
                the season's hottest looks.
            </p>
            <button onclick="window.location.href='dashboard.php'"
                class="bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-4 py-2 rounded-md hover:scale-105 transition-transform duration-500">
                Get Started →
            </button>
        </div>
    </section>

    <section class=" h-16 max-lg:hidden"></section>

    <section class="mx-12 flex justify-between space-x-6 object-contain max-lg:hidden">
        <div class="w-1/3 -mt-16 relative group">
            <!-- First Image (Background) -->
            <img src="landing_src/image2a.png" alt=""
                class="w-full h-[33rem] rounded-tl-none rounded-3xl opacity-50 transition-transform duration-500 group-hover:scale-75" />
            <!-- Second Image (Overlapping) -->
            <img src="landing_src/image2.png" alt=""
                class="absolute top-0 left-0 w-full h-[33rem] object-contain z-10 transition-transform duration-500 group-hover:scale-110" />
            <button
                class="float-end bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-8 py-2 rounded-md font-bold transition-transform duration-500">
                Shop Now @ 399 /-
            </button>
        </div>
        <div class="w-1/3 -mt-28 relative group">
            <!-- First Image (Background) -->
            <img src="landing_src/image3a.png" alt=""
                class="w-full h-[33rem] rounded-tr-none rounded-3xl opacity-50 transition-transform duration-500 group-hover:scale-75 " />

            <!-- Second Image (Overlapping) -->
            <img src="landing_src/image3.png" alt=""
                class="absolute top-0 left-0 w-full h-[33rem] object-contain z-10 transition-transform duration-500 group-hover:scale-110" />
            <button
                class="float-end bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-8 py-2 rounded-md font-bold transition-transform duration-500">
                Shop Now @ 399 /-
            </button>
        </div>
    </section>

    <section class="mx-auto flex justify-center flex-col items-center h-[40rem] w-[20rem] lg:-mt-[32rem] ">
        <div class="relative w-[26rem] h-[30rem] overflow-hidden">
            <!-- First Image -->
            <img src="landing_src/image7.png" alt="Image 1"
                class="absolute inset-0 w-full h-full object-cover animate-upscale" />

            <!-- Second Image -->
            <img src="landing_src/image8.png" alt="Image 2"
                class="absolute inset-0 w-full h-full object-cover animate-downscale" />
        </div>
        <button
            class="bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-8 py-2 rounded-md font-bold transition-transform duration-500 float-end cursor-default ">
            Shop Now @ 399 /-
        </button>
    </section>

    <section class="py-4 mx-10 ">
        <div class="">
            <h1
                class="text-2xl font-bold text-center bg-gradient-to-r from-fuchsia-700 via-violet-600 to-blue-500 bg-clip-text text-transparent">
                " Design your own Era... "
            </h1>
            <h5 class="text-xl my-4 text-gray-800 text-center">
                customise your own t-shirt with your own design
                <strong> @ just 59/- </strong> only...
            </h5>
        </div>
        <div class="flex justify-center items-center gap-x-8 max-lg:flex-col ">
            <div class="flex flex-col justify-center items-center">
                <img src="landing_src/image10.png" alt="" class="w-[23rem] h-[30rem]" />
                <button
                    class="bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-8 py-2 rounded-md font-bold transition-transform duration-500 float-end cursor-default -m-1">
                    customise t-shirt @ 59 /-
                </button>
            </div>
            <div class="w-[22rem] lg:w-[30rem] text-center max-lg:py-4">
                <p class="text-xl leading-relaxed max-lg:text-justify">
                    Experience fashion that's truly yours. Our brand offers
                    <strong>premium-quality apparel </strong> with the freedom to
                    <strong>customize your style</strong> From
                    <strong>durable fabrics</strong> to flawless stitching, every piece
                    reflects
                    <strong>comfort, creativity, and craftsmanship</strong> Stand out
                    with unique designs that blend
                    <strong>trend, comfort, and individuality</strong> – because your
                    fashion should be as unique as you are. 🌟 <br />
                </p>
            </div>
            <div class="flex flex-col justify-center items-center">
                <img src="landing_src/image12.png" alt="" class="w-[23rem] h-[30rem]" />
                <button
                    class="bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white px-8 py-2 rounded-md font-bold transition-transform duration-500 float-end cursor-default -m-1">
                    customise t-shirt @ 59 /-
                </button>
            </div>
        </div>
    </section>

    <section class="flex max-lg:flex-col justify-center items-center mx-8 mb-16 max-lg:gap-y-4 ">
        <div
            class="w-[25rem] lg:-mr-20 bg-gradient-to-r from-fuchsia-500/50 via-violet-600/50 to-blue-500/50 p-2 rounded-lg">
            <img src="landing_src/image16.png" alt="" class="w-full h-full" />
            <h1
                class="text-2xl font-bold text-center bg-gradient-to-r from-fuchsia-700 via-violet-600 to-blue-500 bg-clip-text text-transparent py-2 pt-4">
                Quality That Speaks for Itself
            </h1>
            <p class="text-lg text-center">
                Crafted with <strong>premium fabrics</strong> and precise stitching,
                our apparel offers <strong>durability and style</strong> that stands
                the test of time. 🌟
            </p>
        </div>
        <div class="lg:w-[45rem] w-full h-auto lg:-mt-36 max-lg:hidden">
            <img src="landing_src/image9.png" alt="" class="w-full h-full" />
        </div>
        <div
            class="w-[25rem] lg:-ml-20 bg-gradient-to-r from-fuchsia-500/50 via-violet-600/50 to-blue-500/50 p-2 rounded-lg ">
            <img src="landing_src/image11.png" alt="" class="w-full h-full" />
            <h1
                class="text-2xl font-bold text-center bg-gradient-to-r from-fuchsia-700 via-violet-600 to-blue-500 bg-clip-text text-transparent py-2 pt-4">
                Comfort You Can Rely On
            </h1>
            <p class="text-lg text-center">
                Enjoy <strong>breathable, lightweight fabrics</strong> designed for
                all-day ease, offering a perfect blend of
                <strong>style and comfort</strong>. ✨
            </p>
        </div>
    </section>

    <hr class="border-t-4 border-gray-500/80 w-[80%] mx-auto max-lg:hidden" />

    <section class="max-lg:hidden">
        <h1
            class="text-2xl font-bold text-center bg-gradient-to-r from-fuchsia-700 via-violet-600 to-blue-500 bg-clip-text text-transparent mb-10">
            Many More Designs Waiting for you...
        </h1>
        <div class="flex justify-center items-center gap-x-8 mx-12 ">
            <div class="w-[25rem] h-[27rem]">
                <img src="landing_src/image14.png" alt="" class="w-full h-full" />
            </div>
            <div class="w-[25rem] h-[27rem]">
                <img src="landing_src/image15.png" alt="" class="w-full h-full" />
            </div>
            <div class="w-[25rem] h-[27rem]">
                <img src="landing_src/image17.png" alt="" class="w-full h-full" />
            </div>
        </div>
    </section>

    <hr class="border-t-4 border-gray-500/80 w-[80%] mx-auto mt-16 " />
    <p class="text-center text-gray-500 w-[80%] mx-auto ">
        <strong>
            " Our Designs are not limited to these, we have more designs... check
            out for more designs... "
        </strong>
    </p>
    <hr class="border-t-4 border-gray-500/80 w-[80%] mx-auto " />

    <section class="lg:mr-24 mr-12 mt-10">
        <ul class="ul mx-auto w-[95%]">
            <li class="li">
                <div class="details">
                    <img class="liimg" src="landing_src/ban1.avif" />
                </div>
            </li>
            <li class="li">
                <div class="details">
                    <img class="liimg" src="landing_src/ban2.jpg" />
                </div>
            </li>
            <li class="li">
                <div class="details">
                    <img class="liimg" src="landing_src/ban3.avif" />
                </div>
            </li>
            <li class="li">
                <div class="details">
                    <img class="liimg" src="landing_src/ban8.png" />
                </div>
            </li>
            <li class="li ">
                <div class="details">
                    <img class="liimg" src="landing_src/ban5.jpg" />
                </div>
            </li>
            <li class="li ">
                <div class="details">
                    <img class="liimg" src="landing_src/ban6.jpg" />
                </div>
            </li>
            <li class="li ">
                <div class="details">
                    <img class="liimg" src="landing_src/ban7.jpg" />
                </div>
            </li>
            <li class="li">
                <div class="details">
                    <img class="liimg" src="landing_src/ban9.jpg" />
                </div>
            </li>
            <li class="li">
                <div class="details">
                    <img class="liimg" src="landing_src/ban4.jpg" />
                </div>
            </li>
        </ul>
    </section>

    <hr class="border-t-4 border-gray-500/80 w-[80%%] mx-auto mt-24" />

    <footer class="flex max-lg:flex-col lg:h-96 h-fit bg-white ">
        <div class="flex flex-col p-10 lg:w-1/3 w-full lg:border-r-2 border-b-2 border-gray-500 h-full">
            <h1 class="text-4xl font-bold">nextEra</h1>
            <p class="text-xl mb-10">Wear Your Imagination</p>
            <strong>
                Follow us on Instagram:
                <a href="https://www.instagram.com/nextera_clothing/" class="text-blue-500" target="_blank">@nextEra</a>
                <br />
                Follow us on Facebook:
                <a href="https://www.facebook.com/nextera.clothing" class="text-blue-500" target="_blank">@nextEra</a>
                <br />
                Follow us on Twitter:
                <a href="https://x.com/nextera_clothing" class="text-blue-500" target="_blank">@nextEra</a>
            </strong>
        </div>
        <div class="flex flex-col items-center lg:w-1/3 w-full lg:border-r-2 border-b-2 border-gray-500 h-full">
            <h1 class="text-3xl font-semibold py-6">contact us</h1>
            <p class="text-md">
                <strong>
                    Email:
                    <a href="mailto:nextera@gmail.com" class="text-blue-500" target="_blank">nextera@gmail.com</a>
                    <br />
                    Phone:
                    <a href="tel:+919708681252" class="text-blue-500" target="_blank">+91 9708681252</a>
                    <br />
                    Whatsapp:
                    <a href="https://wa.me/919708681252" class="text-blue-500" target="_blank">+91 9708681252</a>
                    <br />
                    Address:
                    <a href="https://www.google.com/maps/place/123,+Main+Street,+Anytown,+India" class="text-blue-500"
                        target="_blank">123, Main Street, Anytown, India</a>
                </strong>
                <br />
            </p>
            <div class="flex justify-center items-center gap-x-4 mt-8 mb-4">
                <a class="w-10 h-10" target="_blank" href="https://www.instagram.com/nextera_clothing/">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M194.4 211.7a53.3 53.3 0 1 0 59.3 88.7 53.3 53.3 0 1 0 -59.3-88.7zm142.3-68.4c-5.2-5.2-11.5-9.3-18.4-12c-18.1-7.1-57.6-6.8-83.1-6.5c-4.1 0-7.9 .1-11.2 .1c-3.3 0-7.2 0-11.4-.1c-25.5-.3-64.8-.7-82.9 6.5c-6.9 2.7-13.1 6.8-18.4 12s-9.3 11.5-12 18.4c-7.1 18.1-6.7 57.7-6.5 83.2c0 4.1 .1 7.9 .1 11.1s0 7-.1 11.1c-.2 25.5-.6 65.1 6.5 83.2c2.7 6.9 6.8 13.1 12 18.4s11.5 9.3 18.4 12c18.1 7.1 57.6 6.8 83.1 6.5c4.1 0 7.9-.1 11.2-.1c3.3 0 7.2 0 11.4 .1c25.5 .3 64.8 .7 82.9-6.5c6.9-2.7 13.1-6.8 18.4-12s9.3-11.5 12-18.4c7.2-18 6.8-57.4 6.5-83c0-4.2-.1-8.1-.1-11.4s0-7.1 .1-11.4c.3-25.5 .7-64.9-6.5-83l0 0c-2.7-6.9-6.8-13.1-12-18.4zm-67.1 44.5A82 82 0 1 1 178.4 324.2a82 82 0 1 1 91.1-136.4zm29.2-1.3c-3.1-2.1-5.6-5.1-7.1-8.6s-1.8-7.3-1.1-11.1s2.6-7.1 5.2-9.8s6.1-4.5 9.8-5.2s7.6-.4 11.1 1.1s6.5 3.9 8.6 7s3.2 6.8 3.2 10.6c0 2.5-.5 5-1.4 7.3s-2.4 4.4-4.1 6.2s-3.9 3.2-6.2 4.2s-4.8 1.5-7.3 1.5l0 0c-3.8 0-7.5-1.1-10.6-3.2zM448 96c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96zM357 389c-18.7 18.7-41.4 24.6-67 25.9c-26.4 1.5-105.6 1.5-132 0c-25.6-1.3-48.3-7.2-67-25.9s-24.6-41.4-25.8-67c-1.5-26.4-1.5-105.6 0-132c1.3-25.6 7.1-48.3 25.8-67s41.5-24.6 67-25.8c26.4-1.5 105.6-1.5 132 0c25.6 1.3 48.3 7.1 67 25.8s24.6 41.4 25.8 67c1.5 26.3 1.5 105.4 0 131.9c-1.3 25.6-7.1 48.3-25.8 67z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://wa.me/919708681252">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M92.1 254.6c0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6L152 365.2l4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8c0-35.2-15.2-68.3-40.1-93.2c-25-25-58-38.7-93.2-38.7c-72.7 0-131.8 59.1-131.9 131.8zM274.8 330c-12.6 1.9-22.4 .9-47.5-9.9c-36.8-15.9-61.8-51.5-66.9-58.7c-.4-.6-.7-.9-.8-1.1c-2-2.6-16.2-21.5-16.2-41c0-18.4 9-27.9 13.2-32.3c.3-.3 .5-.5 .7-.8c3.6-4 7.9-5 10.6-5c2.6 0 5.3 0 7.6 .1c.3 0 .5 0 .8 0c2.3 0 5.2 0 8.1 6.8c1.2 2.9 3 7.3 4.9 11.8c3.3 8 6.7 16.3 7.3 17.6c1 2 1.7 4.3 .3 6.9c-3.4 6.8-6.9 10.4-9.3 13c-3.1 3.2-4.5 4.7-2.3 8.6c15.3 26.3 30.6 35.4 53.9 47.1c4 2 6.3 1.7 8.6-1c2.3-2.6 9.9-11.6 12.5-15.5c2.6-4 5.3-3.3 8.9-2s23.1 10.9 27.1 12.9c.8 .4 1.5 .7 2.1 1c2.8 1.4 4.7 2.3 5.5 3.6c.9 1.9 .9 9.9-2.4 19.1c-3.3 9.3-19.1 17.7-26.7 18.8zM448 96c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96zM148.1 393.9L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5c29.9 30 47.9 69.8 47.9 112.2c0 87.4-72.7 158.5-160.1 158.5c-26.6 0-52.7-6.7-75.8-19.3z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://www.facebook.com/nextera.clothing">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://www.messenger.com/t/nextera.clothing">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M256.6 8C116.5 8 8 110.3 8 248.6c0 72.3 29.7 134.8 78.1 177.9 8.4 7.5 6.6 11.9 8.1 58.2A19.9 19.9 0 0 0 122 502.3c52.9-23.3 53.6-25.1 62.6-22.7C337.9 521.8 504 423.7 504 248.6 504 110.3 396.6 8 256.6 8zm149.2 185.1l-73 115.6a37.4 37.4 0 0 1 -53.9 9.9l-58.1-43.5a15 15 0 0 0 -18 0l-78.4 59.4c-10.5 7.9-24.2-4.6-17.1-15.7l73-115.6a37.4 37.4 0 0 1 53.9-9.9l58.1 43.5a15 15 0 0 0 18 0l78.4-59.4c10.4-8 24.1 4.5 17.1 15.6z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://x.com/nextera_clothing">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="flex flex-col p-8 gap-y-4 lg:w-1/3 w-full h-full border-b-2 border-gray-500">
            <div class="flex gap-x-4">
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">20k+</h1>
                    <p class="text-center">Happy Customers</p>
                </div>
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">1000+</h1>
                    <p class="text-center">Products Sold every day</p>
                </div>
            </div>
            <div class="flex gap-x-4">
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">25+</h1>
                    <p class="text-center">States of India</p>
                </div>
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">4.9 ★</h1>
                    <p class="text-center">Customer Rating</p>
                </div>
            </div>
            <div class="flex gap-x-4">
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">500+</h1>
                    <p class="text-center">Custom Designs Created</p>
                </div>
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">99%</h1>
                    <p class="text-center">Customer Satisfaction</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>