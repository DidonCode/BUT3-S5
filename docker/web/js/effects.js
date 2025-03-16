function createSparkle(element, speed, espacement) {
    setInterval(() => {
        for(let i =0; i <= Math.floor(Math.random() * 4); i++){
            setTimeout(() => {

                const sparkle = document.createElement('div');
                sparkle.style.position = 'absolute';
                sparkle.style.width = '5px';
                sparkle.style.height = '5px';
                sparkle.style.backgroundColor = 'gold';
                sparkle.style.borderRadius = '50%';

                let space = Math.random() * (espacement - -espacement) - espacement;
                const boxRect = element.getBoundingClientRect();
                const position = Math.random() * ((boxRect.width - space) * 2 + boxRect.height * 2);

                if (position < boxRect.width) {
                    sparkle.style.top = `${-space}px`;
                    sparkle.style.left = `${position}px`;
                } else if (position < boxRect.width + boxRect.height) {
                    sparkle.style.top = `${position - boxRect.width}px`;
                    sparkle.style.right = `${-space}px`;
                } else if (position < boxRect.width * 2 + boxRect.height) {
                    sparkle.style.bottom = `${-space}px`;
                    sparkle.style.left = `${boxRect.width - (position - (boxRect.width + boxRect.height))}px`;
                } else {
                    sparkle.style.top = `${boxRect.height - (position - (boxRect.width * 2 + boxRect.height))}px`;
                    sparkle.style.left = `${-space}px`;
                }

                sparkle.style.zIndex = "6";
                sparkle.style.opacity = '1';
                sparkle.style.transition = 'opacity 1s ease-out, transform 1s ease-out';
                element.appendChild(sparkle);

                setTimeout(() => {
                    sparkle.style.opacity = '0';
                    sparkle.style.transform = 'scale(2)';
                }, 50);

                setTimeout(() => {
                    sparkle.remove();
                }, 1000);
            }, Math.floor(Math.random() * 800));
        }
    }, speed);
}