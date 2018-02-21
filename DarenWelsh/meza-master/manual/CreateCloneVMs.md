# Create Clones of Your VMs
This manual explains how to create clones of your VMs. A clone is a copy of the entire VM. A snapshot is just a saved point of a VM in the configuration over time. Sometimes it is useful to have a clone of a VM. For example, you may wish to run more than one server at a time.

## Case 1: Cloning after OS install, before dev-networking.sh
Run the following steps to create the clone VM:

1. Shut down your VM with `shutdown -h now`
1. In the VirtualBox Manager window, select your VM and click on the "Machine" menu
1. Click "Clone"
1. Name your clone
1. Select "Reinitialize the MAC address of all network cards" and click "Next". This is necessary if you want to run the clones at the same time with successful networking capability.
1. Select "Full clone" and click "Next"
1. Select "Everything" and click "Clone"

Now you must do a little work to fix the networking settings for the clone:

1. Start your VM
1. Log in
1. Open your VM network settings, find the MAC Address for Adapter 1
1. `vi /etc/sysconfig/network-scripts/ifcfg-eth0`
1. Change HWADDR to match your clone's Adapter 1 MAC Address
1. `rm -f /etc/udev/rules.d/70-persistent-net.rules`

At this point you either need to reboot `shutdown -r now` or shut down `shutdown -h now` for the settings to update. Then your clone should have functioning networking. In this case, you can now follow the steps to set up SSH.


## Case 2: Cloning after OS install, after dev-networking.sh
Run the following steps to create the clone VM:

1. Shut down your VM with `shutdown -h now`
1. In the VirtualBox Manager window, select your VM and click on the "Machine" menu
1. Click "Clone"
1. Name your clone
1. Select "Reinitialize the MAC address of all network cards" and click "Next". This is necessary if you want to run the clones at the same time with successful networking capability.
1. Select "Full clone" and click "Next"
1. Select "Everything" and click "Clone"

Now you must do a little work to fix the networking settings for the clone. Note that for CentOS 7, some steps are not necessary.

1. Start your VM
1. Log in
1. (CentOS 6 only) Open your VM network settings, find the MAC Address for Adapter 1
1. (CentOS 6 only) `vi /etc/sysconfig/network-scripts/ifcfg-eth0`
1. (CentOS 6 only) Change HWADDR to match your clone's Adapter 1 MAC Address
1. (CentOS 6 only) Open your VM network settings, find the MAC Address for Adapter 2
1. (CentOS 6 only) `vi /etc/sysconfig/network-scripts/ifcfg-eth1`
1. (CentOS 6 only) Change HWADDR to match your clone's Adapter 2 MAC Address
1. Optional: If you want to access this VM from a different IP address, change that in `ifcfg-eth1` (CentOS 6) or `ifcfg-enp0s8` (CentOS 7) as well.
1. (CentOS 6 only) `rm -f /etc/udev/rules.d/70-persistent-net.rules`

At this point you either need to reboot `shutdown -r now` or shut down `shutdown -h now` for the settings to update. Then your clone should have functioning networking.
