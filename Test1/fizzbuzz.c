#include <stdio.h>
#include <math.h>
#include <unistd.h>

int checkPrime(int n)
{
    int i, flag = 1;

    for (i = 2; i <= sqrt(n); i++)
    {
        if (n % i == 0)
        {
            flag = 0;
            break;
        }
    }

    if (n <= 1)
        flag = 0;
    else if (n == 2)
        flag = 1;

    if (flag == 1)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}

int main()
{
    int i = 0;
    FILE *fp;

    if (access("fizzbuzz.log", F_OK) == 0)
    {
        fp = fopen("fizzbuzz.log", "a");
    }
    else
    {
        fp = fopen("fizzbuzz.log", "w");
    }
    fp = fopen("fizzbuzz.log", "a");
    
    for (i = 1; i <= 500; i++)
    {
        if (checkPrime(i) == 1)
        {
            printf("FIZZBUZZ++\n");
            fprintf(fp, "FIZZBUZZ++\n");
        }
        else if (i % 3 == 0 && i % 5 == 0)
        {
            printf("FIZZBUZZ\n");
            fprintf(fp, "FIZZBUZZ\n");
        }
        else if (i % 3 == 0)
        {
            printf("FIZZ\n");
            fprintf(fp, "FIZZ\n");
        }
        else if (i % 5 == 0)
        {
            printf("BUZZ\n");
            fprintf(fp, "BUZZ\n");
        }
        else
        {
            printf("%d\n", i);
            fprintf(fp, "%d\n", i);
        }
    }
    
    fclose(fp);

    return 0;
}