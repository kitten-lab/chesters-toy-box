import time #well-spent
import sys #functional
import random #results-are-intended
import string #the-pieces-together
import readline #and-remember-yourself
import json #momoa...?
import textwrap #and wroll

ANI = ['A', 'B', 'S', 'D', 'K', 'I', 'Q', 'X', 'E', 'P', 'L', 'W']
ani = ['a', 'b', 'c', 'd','e','f','g','h','i','j']
quai = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9']
kras = [
'◇', '◆', '◈',
'□', '■', '▢', '▣',
'△', '▲', '▽', '▼',
'○', '●',
':', ';', '.', ',', '~', '^', '*', 'v',
'+', '-', '=', '|', '<', '>', '@', '#', '%', '&', '{', '}', '[', ']', '(', ')',
]
POOL = quai + kras
def generate_kven():
    part1 = ''.join(random.choice(ANI) for _ in range(3))
    part2 = ''.join(random.choice(quai) for _ in range(3))
    def random_sigil():
        return ''.join(random.choice(POOL) for _ in range(7))
    def mirror_sigil():
        if random.random() < 0.3:  # 30% symmetrical
            left = ''.join(random.choice(POOL) for _ in range(3))
            center = random.choice(POOL)
            return left + center + left[::-1]
        else:
            return ''.join(random.choice(POOL) for _ in range(7))
    def crest_sigil():
        a = random.choice(POOL)
        b = random.choice(POOL)
        c = random.choice(POOL)
        return a + b + c + b + a + random.choice(POOL) + random.choice(POOL)
    def generate_sigil():
        r = random.random()
        if r < 0.25:
            return mirror_sigil()
        elif r < 0.40:
            return crest_sigil()
        else:
            return random_sigil()

    return part1 + part2

def printer():
        print("\033[90m|K \u001b[92m{part1}-{part2}\033[90m ꓘ|\u001b[0m" " | .:{generate_sigil()}:.")

def random_cluster(width=7):
    return ''.join(random.choice(kras) for _ in range(width))
    

def animate_gate():
    idx = 0
    while True:
        sys.stdout.write("\r                                  " + generate_kven() + "")
        sys.stdout.flush()
        time.sleep(0.05)

        idx += 1
        if idx == 13:
            break

def mint_kven():
    animate_gate()
    sys.stdout.write("\r    t-ꓘven.gen: Success!\n")
    sys.stdout.flush()
