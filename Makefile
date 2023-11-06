sail := vendor/bin/sail

.PHONY: rm
rm:
	$(sail) down -v

.PHONY: docker-setup
docker-setup:
	$(sail) up -d # get services running
	sleep 120

.PHONY: backend-install
backend-install:
	$(sail) composer i

.PHONY: backend-setup
backend-setup:
	make backend-install
	$(sail) artisan key:generate

.PHONY: fresh
fresh:
	$(sail) artisan migrate:fresh --seed

.PHONY: frontend-clean
frontend-clean:
	rm -rf node_modules 2>/dev/null || true
	rm package-lock.json 2>/dev/null || true
	rm yarn.lock 2>/dev/null || true
	$(sail) yarn cache clean

.PHONY: frontend-install
frontend-install:
	make frontend-clean
	$(sail) yarn install
	$(sail) npx mix

.PHONY: dev
dev:
	make docker-setup
	make backend-setup
	make frontend-install

.PHONY: watch
watch:
	#$(sail) npm run craftable-watch



opt:
	$(sail) artisan optimize
	$(sail) artisan route:trans:cache
	$(sail) artisan route:clear

run dev:
	npm run dev


rlist:
	$(sail)  artisan optimize
	$(sail)  artisan route:list
dump:
	$(sail)	composer dump-autoload

perm:
	chgrp -R www-data storage bootstrap/cache
	chmod -R ug+rwx storage bootstrap/cache
	chmod -R 777 storage


