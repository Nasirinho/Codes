
public class LinkedListNode <I extends java.lang.Comparable<? super I>> {
	
	private I element;
	private LinkedListNode<I> next;
	
	public LinkedListNode(I element) {
		this.element = element;
		this.next = null;
	}
	
	public LinkedListNode(I element, LinkedListNode<I> next) {
		this.element = element;
		this.next = next;
	}
	
	public I getElement() {
		return (I)this.element;
	}
	
	public LinkedListNode<I> getNext(){
		return (LinkedListNode<I>)this.next;
	}
	
	public void setElement(I element) {
		this.element = element;
	}
	
	public void setNext(LinkedListNode<I> next) {
		this.next = next;
	}

}
