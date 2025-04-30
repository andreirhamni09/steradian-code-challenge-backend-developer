FROM jenkins/jenkins:lts

# Install dependencies
USER root

# Update package list dan instal PHP, Composer, dan ekstensi lainnya
RUN apt-get update && apt-get install -y \
    php-cli \
    php-curl \
    php-mbstring \
    php-xml \
    php-zip \
    curl \
    git \
    unzip \
    && apt-get clean

# Install Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js dan NPM (Jika diperlukan untuk Laravel Mix)
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

# Kembali ke user jenkins
USER jenkins

# Set Jenkins home
ENV JENKINS_HOME /var/jenkins_home
