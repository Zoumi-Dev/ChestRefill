ChestRefill
===========
* **ChestRefill** is a plugin developed entirely by **Clouds#0667**.

What is it for?
==============
* **ChestRefill** allows chests to be *regenerated automatically* when the time is up.

Config File
===========
* ChestRefill contains a configuration file for more possibilities!

```yml
chest:
  # schéma x:y:z:worldName exemple
  # - "0.5:64:0.5:world"

items:
  # Items that may appear in the chests
  # schéma id:meta:count:enchantId:echantLevel exemple
  # with enchant - "1:0:1:9:5" without enchant - "1:0:1:none:0"

# What is the minimum number of items per box?
item-min-per-chest: 1
# What is the maximum number of items per box?
item-max-per-chest: 6
# Message during the cooldown before the chestrefill {time} = time left
before-the-chestrefill: "The chest refill will take place in §e{time} §fsecond(s)."
# Sound during the cooldown of messages before the chestrefill.
sound-before-the-chestrefill: "note.harp"
# When should a message to warn of chestrefill time be sent (in second)
time-before-the-chestrefill: [60, 30, 15, 10, 5, 4, 3, 2, 1]
# Message at the chestrefill.
chestrefill-broadcast: "The chests have been regenerated!"
# Sound in chest refill.
sound-chestrefill: "beacon.power"
# How often does a chestrefill take place? (in second)
time: 3600
# Message when running the /chestrefill command.
command-chestrefill-message: "The chest refill will take place in §e{time} §fsecond(s)."
```

Support
=======
* If you have any **ideas** for additions or a **bug** to report, please join the server discord by clicking [here](https://discord.gg/kARpD3DsdU).