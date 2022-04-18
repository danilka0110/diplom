<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        * {
            margin
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        img {
            width: 60%;
        }
    </style>


        <img src="https://prv2.lori-images.net/abstraktnyi-fon-0000930858-preview.jpg" alt="nature" crossorigin>


        <script>

        function getColor(imageElem, ratio) {
            const canvas = document.createElement('canvas');

            let width = canvas.width = imageElem.width;
            let height = canvas.height = imageElem.height;

            const context = canvas.getContext('2d');
            context.drawImage(imageElem, 0, 0);

            let data, length;
            let i = -4, count = 0;

            try {
                data = context.getImageData(0, 0, width, height)
                length = data.data.length
            } catch (err) {
                console.log(error(err))
                return {
                    R: 0,
                    G: 0,
                    B: 0
                }
            }
            let R,G,B
            R = G = B = 0

            while((i += ratio * 4) < length) {
                ++count

                R += data.data[i]
                G += data.data[i + 1]
                B += data.data[i + 2]
            }

            R = ~~(R / count)
            G = ~~(G / count)
            B = ~~(B / count)

            return {
                R,
                G,
                B,
            }
        }

        const image = document.querySelector('img');
        image.onload = function() {
            const {R, G, B} = getColor(image, 4)

            document.body.style.background = `radial-gradient(rgb(${R}, ${G}, ${B}), #333)`
        }
        </script>

</body>
</html>