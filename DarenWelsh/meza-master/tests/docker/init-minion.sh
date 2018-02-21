#!/bin/sh
#
# Get a container ready to be a minion

# Initiate container
# FIXME #828: pre-yum has more than we need. Go lighter.
docker_repo="jamesmontalvo3/meza-docker-pre-yum:latest"
is_minion=yes
source "$m_meza_host/tests/docker/init-container.sh" "none"

# Container is a minion. Give access to meza-ansible from controller CONTAINER 1
docker cp /tmp/controller.id_rsa.pub "$container_id:/tmp/meza-ansible.id_rsa.pub"
docker cp "$m_meza_host/src/scripts/ssh-users/setup-minion-user.sh" "$container_id:/tmp/setup-minion-user.sh"
${docker_exec[@]} bash /tmp/setup-minion-user.sh

# Turn off host key checking for user meza-ansible, to avoid prompts
${docker_exec[@]} bash -c 'echo -e "Host *\n   StrictHostKeyChecking no\n   UserKnownHostsFile=/dev/null" > /opt/conf-meza/users/meza-ansible/.ssh/config'

# Allow SSH login
# WARNING: This is INSECURE and for test environment only
${docker_exec[@]} sed -r -i 's/UsePAM yes/UsePAM no/g;' /etc/ssh/sshd_config
${docker_exec[@]} systemctl restart sshd
