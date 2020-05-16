# Stdout Logger

## Description

A stdout log servo instead of Linux output redirection. 
The logger is suitable for resident memory program. 
The servo is suitable for non-resident memory program

## Logger

### Limitations

+ Echoing {servoed_exit_identify} is the only way to exit in servoed script
+ Servoed script cannot do anything after echo {servoed_exit_identify}
+ Servoed script cannot exit via some functions as exit or die
+ Servoed script cannot exit if an exception occurred
+ Servoed script cannot exit if an error (includes fatal error) occurred

### Usage

```
php t.php | php logger.php {log_path} {servoed_exit_identify} {log_flush_interval} {log_buffer_flush_interval}
```

### Perf Test

#### Round 1

```
php t_perf.php >> ./test.log

# Sys Load (1min): 3.54638671875
# Duration: 83.579638957977s
```

```
php t_perf.php | php logger.php ./test2.log ###exit### 100000000 10000

# Sys Load (1min): 3.54248046875
# Duration: 36.729868173599s
```

#### Round 2

```
php t_perf.php >> ./test3.log

# Sys Load (1min): 2.91845703125
# Duration: 83.216265916824s
```

```
php t_perf.php | php logger.php ./test4.log ###exit### 100000000 10000

# Sys Load (1min): 3.07177734375
# Duration: 35.461591959s
```

#### Round 3

```
php t_perf.php >> ./test5.log

# Sys Load (1min): 3.04931640625
# Duration: 82.288384914398s
```

```
php t_perf.php | php logger.php ./test6.log ###exit### 100000000 10000

# Sys Load (1min): 2.59912109375
# Duration: 37.429664134979s
```

## Servo

### Limitations

+ The stdout will not be outputted before the servoed script exits.

### Usage

```
php servo.php {cmd} {log_path}
```

### Perf Test

#### Round 1

```
php t_perf.php >> ./test.log

# Sys Load (1min): 2.76513671875
# Duration: 86.234095096588s
```

```
php servo.php 'php t_perf.php' './test2.log'

# Sys Load (1min): 3.93603515625
# Duration: 30.150074958801s
```

#### Round 2

```
php t_perf.php >> ./test3.log

# Sys Load (1min): 3.92333984375
# Duration: 83.979343891144s
```

```
php servo.php 'php t_perf.php' './test4.log'

# Sys Load (1min): 3.29150390625
# Duration: 28.674187898636s
```

#### Round 3

```
php t_perf.php >> ./test5.log

# Sys Load (1min): 3.24365234375
# Duration: 82.035503864288s
```

```
php servo.php 'php t_perf.php' './test6.log'

# Sys Load (1min): 3.38720703125
# Duration: 27.534267902374s
```
