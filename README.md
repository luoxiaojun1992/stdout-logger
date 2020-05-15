# Stdout Logger

## Description

A stdout log servo instead of Linux output redirection which is suitable for resident memory program.

## Limitations

+ Echoing {servoed_exit_identify} is the only way to exit in servoed script
+ Servoed script cannot do anything after echo {servoed_exit_identify}
+ Servoed script cannot exit via some functions as exit or die
+ Servoed script cannot exit if an exception occurred
+ Servoed script cannot exit if an error (includes fatal error) occurred

## Usage

```
php t.php | php logger.php {log_path} {servoed_exit_identify} {log_flush_interval} {log_buffer_flush_interval}
```

## Test Command

```
php t.php | php logger.php ./test.log ###exit### 100000000 10000
```

## Perf Test

### Round 1

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

### Round 2

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

### Round 3

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
