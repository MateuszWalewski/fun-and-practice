#include <iostream>
#include <ctime>
#include <iomanip>

#include "ArraySorterSelectionSort.h"
#include "ArraySorterInsertionSort.h"
#include "ArraySorterBubbleSort.h"
#include "ArraySorterMergeSort.h"
#include "ArraySorterQuickSort.h"
#include "ArraySorterFactory.h"

using namespace std;


void performMeasurement(ArraySorterFactory::ArraySorterType sorterType, int numberOfElements, int arrayToBeSorted[]);
void displayTitle(ArraySorterFactory::ArraySorterType sorterType, int numberOfElements);
void randomizeArray(int numberOfElements, int arrayToBeRandomized[]);
bool checkIfSorted(int numberOfElements, int arrayToBeChecked[]);
void displayArray(int numberOfElements, int arrayToBeDisplayed[]);

int main()
{
    int numberOfElements = 15000; // change if you like
    int arrayToBeSorted[numberOfElements];

    setprecision(6);
    cout.setf(ios::fixed);
    performMeasurement(ArraySorterFactory::SelectionSort,numberOfElements,arrayToBeSorted);
    performMeasurement(ArraySorterFactory::InsertionSort,numberOfElements,arrayToBeSorted);
    performMeasurement(ArraySorterFactory::BubbleSort,numberOfElements,arrayToBeSorted);
    performMeasurement(ArraySorterFactory::QuickSort,numberOfElements,arrayToBeSorted);
    performMeasurement(ArraySorterFactory::MergeSort,numberOfElements,arrayToBeSorted);

    return 0;
}

void performMeasurement(ArraySorterFactory::ArraySorterType sorterType, int numberOfElements, int arrayToBeSorted[])
{
    displayTitle(sorterType, numberOfElements);
    randomizeArray(numberOfElements, arrayToBeSorted);
    clock_t start,stop;
    double executionTime;
    unique_ptr<ArraySorter> ar = ArraySorterFactory::createArraySorter(sorterType, numberOfElements,arrayToBeSorted);
    start = clock();
    ar->launch();
    stop = clock();
    executionTime = (double)(stop-start) / CLOCKS_PER_SEC;
    cout <<"Sorting status: ";
    if(checkIfSorted(numberOfElements,arrayToBeSorted)) cout <<"Sorted" << endl;
    else cout <<"Not sorted" << endl;
    cout<<endl<<"Elapsed time:   "<<executionTime<<" s"<<endl;
}
void displayTitle(ArraySorterFactory::ArraySorterType sorterType, int numberOfElements)
{
    string title[5] = {"SelectionSort", "InsertionSort", "BubbleSort", "MergeSort", "QuickSort"};
    cout <<"--------------------------------------------------" << endl;
    cout<<"Algorithm type: "<<title[sorterType]<<endl;
    cout<<"Number of elements to sort: "<<numberOfElements<<endl;
    cout <<"--------------------------------------------------" << endl;

}
void randomizeArray(int numberOfElements, int arrayToBeRandomized[])
{
    srand(time(NULL)); // to enforce the same sequence of values after each call
    for(int i=0; i<numberOfElements; i++)
    {
        arrayToBeRandomized[i] = rand()%numberOfElements+1;
    }
}
bool checkIfSorted(int numberOfElements, int arrayToBeChecked[])
{
    bool sorted = true;
    for(int i=0; i<numberOfElements-1; i++)
    {
        if(arrayToBeChecked[i]>arrayToBeChecked[i+1]) sorted = false;

    }
    return sorted;

}
void displayArray(int numberOfElements, int arrayToBeDisplayed[])
{
    for(int i = 0; i < numberOfElements; i ++)
    {
        cout << arrayToBeDisplayed[i] <<" ";
    }
    cout << endl;
}





