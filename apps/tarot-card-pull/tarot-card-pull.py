import json
import random
import time
import readline
from time import sleep


boot_screen = [
    "__________________________________________________________________",
    " ",
    "                          M O I R E   T A R O T   C A R D  P U L L",
    "                                            ==  prototype v0.1 == ",
    "__________________________________________________________________",
    " ",
    " A SILLYLIL APP   BY: S.D.K. MOIRE 'AUBEL'",
    "__________________________________________________________________",
    " ",
    "      +======================================================+",
    "      |------------------------------------------------------|",
    "      |--███╗---███╗-██████╗-██╗██████╗-███████╗-------------|",
    "      |--████╗-████║██╔═══██╗██║██╔══██╗██╔════╝-------------|",
    "      |--██╔████╔██║██║---██║██║██████╔╝█████╗---------------|",
    "      |--██║╚██╔╝██║██║---██║██║██╔══██╗██╔══╝---------------|",
    "      |--██║-╚═╝-██║╚██████╔╝██║██║--██║███████╗-------------|",
    "      |--╚═╝-----╚═╝-╚═════╝-╚═╝╚═╝--╚═╝╚══════╝-------------|",
    "      |---█████╗-██████╗--██████╗-█████╗-███╗---██╗-█████╗---|",
    "      |--██╔══██╗██╔══██╗██╔════╝██╔══██╗████╗--██║██╔══██╗--|",
    "      |--███████║██████╔╝██║-----███████║██╔██╗-██║███████║--|",
    "      |--██╔══██║██╔══██╗██║-----██╔══██║██║╚██╗██║██╔══██║--|",
    "      |--██║--██║██║--██║╚██████╗██║--██║██║-╚████║██║--██║--|",
    "      |--╚═╝--╚═╝╚═╝--╚═╝-╚═════╝╚═╝--╚═╝╚═╝--╚═══╝╚═╝--╚═╝--|",
    "      |------------------------------------------------------|",
    "      +======================================================+",
    " ",
    "       Software Brought to You by  CHESTER'S IMPORTS ",
    "       'Quality provider of unique imports, including you!' ",
    "       copyright '3639 all rights reserved ",
]


class s:
    r = '\033[91m'
    sHg = '\033[102m'
    sHb = '\033[1;33;44m'
    sHy = '\033[103m'
    sHr = '\033[101m'
    sHYr = '\033[1;31;43m'
    g = '\033[1;92m'
    ga = '\033[1;30;49m'
    HWr = '\033[0;31;47m'
    b = '\033[94m'
    y = '\033[93m'
    sU = '\033[4m'
    sB = "\033[2m"
    x = '\033[00m'

with open("major_arcana.json") as f:
    cards = json.load(f)

for line in boot_screen:
    print(line)
    time.sleep(0.05)

print(f"""__________________________________________________________________

 Welcome to MOIRE TAROT. Well.. it is more of an oracle deck, if
 we're being perfectly honest. And honesty is the best policy,
 after all. {s.y}Or is it?{s.x}

 Welcome to MOIRE ARCANA!! That's better.

 Ahem. NOW.........
""", flush=True)

daily_card = random.choice(cards)


def run():
    print(f"""
    WEEEEEEEEEEEELCOME *mysterious voice*
    I see some kind of tarot in your future.

type {s.g}DRAW{s.x} to draw a card. 
type {s.g}END{s.x} to terminate this experience.
    """)


    while True:
        user_input = input(f"{s.sHYr} Command > {s.x} ")

        if user_input.lower() == "end":
            print("Really? That's it?")
            break

        if user_input.lower() == "draw":
            card = random.choice(cards)
            print(f"""
 ░█░█░█▀█░█░█░█▀▄░░░█▀▀░█▀█░█▀▄░█▀▄░░░▀█▀░█▀▀
 ░░█░░█░█░█░█░█▀▄░░░█░░░█▀█░█▀▄░█░█░░░░█░░▀▀█
 ░░▀░░▀▀▀░▀▀▀░▀░▀░░░▀▀▀░▀░▀░▀░▀░▀▀░░░░▀▀▀░▀▀▀

 ▐▀▀▀▀▀▀▌
 ▐ {card['ig_num']} ▌  {card['ig_name']}
 ▐▄▄▄▄▄▄▌
 🚀

 ▐▀▀▀▀▀▀▀▀▀▀▌
 ▐          ▌  {card['ig_name']}
 ▐          ▌  {card['rws_name']}
 ▐   {card['ig_num']}   ▌
 ▐          ▌  {card['ig_def']}
 ▐          ▌  {card['rws_def']}
 ▐▄▄▄▄▄▄▄▄▄▄▌
""")
        if user_input.lower() == "draw 2":
            card = random.sample(cards, k=2)
            card1 = card[0]
            card2 = card[1]
            print(f"""
 ░█▀▀░█▀█░█▀▄░█▀▄░░░▀█▀░
 ░█░░░█▀█░█▀▄░█░█░░░░█░░
 ░▀▀▀░▀░▀░▀░▀░▀▀░░░░▀▀▀░
  
 ▐▀▀▀▀▀▀▀▀▌
 ▐        ▌  {card1['ig_name']}
 ▐        ▌  {card1['rws_name']}
 ▐  {card1['ig_num']}  ▌
 ▐        ▌  {card1['ig_def']}
 ▐        ▌  {card1['rws_def']}
 ▐▄▄▄▄▄▄▄▄▌

   ▐▀▀▀▀▀▀▀▀▀▀▌
   ▐          ▌  {card2['ig_name']}
   ▐          ▌  {card2['rws_name']}
   ▐   {card2['ig_num']}   ▌
   ▐          ▌  {card2['ig_def']}
   ▐          ▌  {card2['rws_def']}
   ▐▄▄▄▄▄▄▄▄▄▄▌
""")

        if user_input.lower() == "draw 3":
            card = random.sample(cards, k=3)
            card1 = card[0]
            card2 = card[1]
            card3 = card[2]
            print(f"""
 ░█░█░█▀█░█░█░█▀▄░░░█▀▀░█▀█░█▀▄░█▀▄░░░▀█▀░█▀▀
 ░░█░░█░█░█░█░█▀▄░░░█░░░█▀█░█▀▄░█░█░░░░█░░▀▀█
 ░░▀░░▀▀▀░▀▀▀░▀░▀░░░▀▀▀░▀░▀░▀░▀░▀▀░░░░▀▀▀░▀▀▀

 ▐▀▀▀▀▀▀▀▀▀▀▌   ▐▀▀▀▀▀▀▀▀▀▀▌   ▐▀▀▀▀▀▀▀▀▀▀▌
 ▐          ▌   ▐          ▌   ▐          ▌ 
 ▐          ▌   ▐          ▌   ▐          ▌  
 ▐   {card1['ig_num']}   ▌   ▐   {card2['ig_num']}   ▌   ▐   {card3['ig_num']}   ▌  
 ▐          ▌   ▐          ▌   ▐          ▌  
 ▐          ▌   ▐          ▌   ▐          ▌  
 ▐▄▄▄▄▄▄▄▄▄▄▌   ▐▄▄▄▄▄▄▄▄▄▄▌   ▐▄▄▄▄▄▄▄▄▄▄▌
""")

#            print(f"{card['ig_num']}")

if __name__ == "__main__":
    run()
