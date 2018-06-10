#! /bin/bash
# check current versions of files against master versions; replace if different

bash -c 'curl -L https://turing.bowdoin.edu/~dparsons/software/checknetwork.txt > /var/www/html/content.txt'
result=$(cmp /var/www/html/content.txt /etc/checknetwork.sh || echo "diff")

# if result is not empty, it outputted "diff", and the files don't match -- replace with new
if [[ ! -z $result ]]
then
	# save old version
	bash -c 'cp /etc/checknetwork.sh /etc/checknetwork.sh.old'
	bash -c 'cp /var/www/html/content.txt /etc/checknetwork.sh'
fi


bash -c 'curl -L https://turing.bowdoin.edu/~dparsons/software/hostmode.txt > /var/www/html/content.txt'
result=$(cmp /var/www/html/content.txt /var/www/html/hostmode.sh || echo "diff")

if [[ ! -z $result ]]
then
	bash -c 'cp /var/www/html/hostmode.sh /var/www/html/hostmode.sh.old'
	bash -c 'cp /var/www/html/content.txt /var/www/html/hostmode.sh'
fi


bash -c 'curl -L https://turing.bowdoin.edu/~dparsons/software/clientmode.txt > /var/www/html/content.txt'
result=$(cmp /var/www/html/content.txt /var/www/html/clientmode.sh || echo "diff")

if [[ ! -z $result ]]
then
	bash -c 'cp /var/www/html/clientmode.sh /var/www/html/clientmode.sh.old'
	bash -c 'cp /var/www/html/content.txt /var/www/html/clientmode.sh'
fi


bash -c 'curl -L https://turing.bowdoin.edu/~dparsons/software/index.txt > /var/www/html/content.txt'
result=$(cmp /var/www/html/content.txt /var/www/html/index.html || echo "diff")

if [[ ! -z $result ]]
then
	bash -c 'cp /var/www/html/index.html /var/www/html/index.html.old'
	bash -c 'cp /var/www/html/content.txt /var/www/html/index.html'
fi


bash -c 'curl -L https://turing.bowdoin.edu/~dparsons/software/welcome_get.txt > /var/www/html/content.txt'
result=$(cmp /var/www/html/content.txt /var/www/html/welcome_get.php || echo "diff")

if [[ ! -z $result ]]
then
	bash -c 'cp /var/www/html/welcome_get.php /var/www/html/welcome_get.php.old'
	bash -c 'cp /var/www/html/content.txt /var/www/html/welcome_get.php'
fi


bash -c 'curl -L https://turing.bowdoin.edu/~dparsons/software/update.txt > /var/www/html/content.txt'
result=$(cmp /var/www/html/content.txt /var/www/html/update.sh || echo "diff")

if [[ ! -z $result ]]
then
	bash -c 'cp /var/www/html/update.sh /var/www/html/update.sh.old'
	bash -c 'cp /var/www/html/content.txt /var/www/html/update.sh'
fi
