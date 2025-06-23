// JavaScript for particle animation (based on G404Error template concept)

(function() {
    var canvas = document.createElement('canvas'),
        ctx = canvas.getContext('2d'),
        width = canvas.width = window.innerWidth,
        height = canvas.height = window.innerHeight,
        particles = [],
        properties = {
            bgColor: 'rgba(13, 13, 13, 1)',
            particleColor: 'rgba(255, 255, 255, 0.2)',
            particleRadius: 3,
            particleCount: 100,
            particleSpeed: 0.5,
            lineColor: 'rgba(255, 255, 255, 0.05)',
            lineThickness: 1,
            lineDistance: 150,
        };

    document.body.appendChild(canvas);

    // Resize canvas on window resize
    window.onresize = function() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    };

    function Particle() {
        this.x = Math.random() * width;
        this.y = Math.random() * height;
        this.velocityX = Math.random() * (properties.particleSpeed * 2) - properties.particleSpeed;
        this.velocityY = Math.random() * (properties.particleSpeed * 2) - properties.particleSpeed;
    }

    Particle.prototype.update = function() {
        this.x += this.velocityX;
        this.y += this.velocityY;

        if (this.x < 0 || this.x > width) {
            this.velocityX = this.velocityX * -1;
        }
        if (this.y < 0 || this.y > height) {
            this.velocityY = this.velocityY * -1;
        }
    };

    Particle.prototype.draw = function() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, properties.particleRadius, 0, Math.PI * 2);
        ctx.fillStyle = properties.particleColor;
        ctx.fill();
    };

    function createParticles() {
        for (var i = 0; i < properties.particleCount; i++) {
            particles.push(new Particle());
        }
    }

    function drawLines() {
        for (var i = 0; i < particles.length; i++) {
            for (var j = i + 1; j < particles.length; j++) {
                var p1 = particles[i];
                var p2 = particles[j];
                var distance = Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2));

                if (distance < properties.lineDistance) {
                    ctx.beginPath();
                    ctx.lineWidth = properties.lineThickness;
                    ctx.strokeStyle = properties.lineColor;
                    ctx.moveTo(p1.x, p1.y);
                    ctx.lineTo(p2.x, p2.y);
                    ctx.stroke();
                }
            }
        }
    }

    function loop() {
        requestAnimationFrame(loop);
        ctx.clearRect(0, 0, width, height);
        ctx.fillStyle = properties.bgColor;
        ctx.fillRect(0, 0, width, height);

        for (var i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }
        drawLines();
    }

    createParticles();
    loop();
})();
