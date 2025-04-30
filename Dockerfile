FROM jenkins/jenkins:lts

USER root

# Install PHP dan ekstensi Laravel
RUN apt-get update && \
    apt-get install -y \
    php-cli \
    php-curl \
    php-mbstring \
    php-xml \
    php-zip \
    git \
    curl \
    unzip \
    apt-transport-https \
    ca-certificates \
    gnupg \
    lsb-release

# Install Docker CLI
RUN curl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg && \
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian $(lsb_release -cs) stable" \
    > /etc/apt/sources.list.d/docker.list && \
    apt-get update && \
    apt-get install -y docker-ce-cli

# Install Docker Compose
RUN curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" \
    -o /usr/local/bin/docker-compose && chmod +x /usr/local/bin/docker-compose

# (Opsional) Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

USER jenkins
